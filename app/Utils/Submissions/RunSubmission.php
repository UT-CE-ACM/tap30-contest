<?php

namespace App\Utils\Submissions;

use App\Models\Log;
use App\Models\Record;
use App\Models\Round;
use App\Models\Run;
use App\Models\Sample;
use App\Models\User;
use Symfony\Component\Process\Exception\RuntimeException;
use Symfony\Component\Process\Process;
use File;

/**
 * Created by PhpStorm.
 * User: mamareza
 * Date: 2/3/17
 * Time: 7:15 PM
 */
class RunSubmission
{
    /**
     * @param User $team
     * @param Round $round
     * @return float
     */
    public static function finalScore(User $team, Round $round){

        $result = 0.0;
        $runs = $team->submits->last()->runs()->whereRoundId($round->id)->get();
        foreach($runs as $run){
            $result += $run->RMSE;
        }
        return $result;
    }

    /**
     * @param Record $record
     * @param Round $round
     */
    public static function determineWinner(Record $record, Round $round){
        $firstTeamScore = RunSubmission::finalScore($record->teams[0], $round);
        $secondTeamScore = RunSubmission::finalScore($record->teams[1], $round);
        if ($secondTeamScore < $firstTeamScore){
            $record->winner_id = $record->teams[1]->id;
            $record->teams[0]->has_lost = true;
            $record->teams[0]->save();
        }
        else{
            $record->winner_id = $record->teams[0]->id;
            $record->teams[1]->has_lost = true;
            $record->teams[1]->save();
        }
        $record->save();
        echo '<div class="clearfix"></div>';
        echo '<p class="text-center result">';
        echo '<b>Winner: </b><button type="button" class="btn btn-success">' . $record->winner->name . '</button>';
        echo '</p>';
    }

    /**
     * Replaces {{ var }} substrings in a given string.
     *
     * @param string $str
     * @param array $items
     * @return string
     */
    public static function contextify(string $str, array $items) {
        $keys = array_keys($items);
        for ($i = 0; $i < count($keys); $i++)
            $keys[$i] = '{{ ' . $keys[$i] . ' }}';
        return str_replace($keys, array_values($items), $str);
    }

    public static function getRMSE($output, $answer){
        $output = explode("\n", trim($output));
        $answer = explode("\n", trim($answer));

        $result = 0.0;
        foreach($output as $key => $value){
            $result += pow((double)$value - (double)$answer[$key],2);
        }
        return sqrt($result / count($output));
    }

    public static function handle(User $team, Round $round){
        echo '<div class="clearfix"></div>';
        echo '<div class="row content">
                <div class="col-md-2 sidenav"></div>
                    <div class="col-md-8 text-left"> 
                        <button type="button" class="btn btn-info">'. $team->name .'</button>';
        $submit = $team->submits->last();
        $submit->load(['problem', 'attachment']);
        $submit->runs()->whereRoundId($round->id)->delete();

        $attachment = $submit->attachment;
        $language = $submit->language;
        $problem = $submit->problem;

        $time_limit = 120; // seconds
        $memory_limit = 200*1024; // kb
        $slug = explode(".", $attachment->real_name)[0];

        // create unique directory in /tmp
        $process = new Process("mktemp -d");
        $process->run();
        if (!$process->isSuccessful()){
            return;
        }
        $tmpDirectory = trim($process->getOutput());
        echo "<p>Temp directory " . $tmpDirectory . "has been created!</p>";

        $context = [
            'tmp_directory' => $tmpDirectory,
            'directory' => $attachment->getWholePath(),
            'problem_slug' => $slug,
            'file_extension' => $language->file_extension,
            'memory_limit' => $problem->memory_limit,
        ];

        // Copy submit file to temp directory
        $source = $context['directory'] . '/' . $attachment->real_name;
        $destination = RunSubmission::contextify('{{ tmp_directory }}/{{ problem_slug }}.{{ file_extension }}', $context);
        $process = new Process("cp ". $source . " " . $destination);
        $process->run();
        if (!$process->isSuccessful()){
            return;
        }
        echo "<p>Submit file " . $source . " has been copied to tmp directory!</p>";

        // Copy Round Attachment to tmp directory
        $source = $round->attachment->getWholePath() . '/' . $round->attachment->real_name;
        $process = new Process("cp ". $source . " " . $tmpDirectory);
        $process->run();
        if (!$process->isSuccessful()){
            return;
        }
        echo "<p>Data file " . $source . " has been copied to tmp directory!</p>";

        $status = '';
        // Compile the code (if we need to)
        if ($language->compile_command) {
            $process = new Process(RunSubmission::contextify('mbox -n -i -r {{ tmp_directory }} -C {{ tmp_directory }} -- ' . $language->compile_command, $context));
            $process->run();
            if (!$process->isSuccessful()) {
                $status = 'CE';
                $compileErrorMessage = $process->getErrorOutput();
            }
        }

        // Run the compiled executable for each test case.
        $execute_command = RunSubmission::contextify('(ulimit -v ' . $memory_limit . '; mbox -n -i -r {{ tmp_directory }} -C {{ tmp_directory }} -- ' . $language->execute_command . ')', $context);
        if ($language->file_extension == 'java'){
            $execute_command = RunSubmission::contextify('mbox -n -i -r {{ tmp_directory }} -C {{ tmp_directory }} -- '. $language->execute_command , $context);
        }
//        echo '<p>'.$execute_command.'</p>';

        echo '<hr>';
        $counter = 1;
        // giving inputs to the executable file and getting outputs
        foreach ($round->test_cases as $test_case) {
            echo "<h4>Test Case " . $counter++ . ":</h4>";
            $test_case->load('attachments');
            $tcInput = File::get($test_case->attachments->first()->getRelativePath());
            $tcOutput = File::get($test_case->attachments->last()->getRelativePath());

            echo '<div class="row">';
            echo '<textarea class="col-md-4" style ="max-height:400px;min-height: 250px;">Run input: '. $tcInput . '</textarea>';
            echo '<textarea class="col-md-4" style ="max-height:400px;min-height: 250px;">Run output: '. $tcOutput . '</textarea>';

            $run = new Run;
            $run->round_id = $round->id;
            $run->submit_id = $submit->id;
            $run->test_case_id = $test_case->id;

            if ($status == 'CE'){
                // Compile Error Exception
                $run->status = $status;
                $run->message = $compileErrorMessage;
                $run->RMSE = 1000;
                $run->save();
                echo "</div><span style='color: red'>Run has been failed because of ". $run->status ."!</span><br>";
                echo "<p><b>Message</b>: " . $run->message . "</p>";
                continue;
            }

            $process = new Process($execute_command);
            $process->setInput($tcInput);
            //FIXME: setTimeout becomes unreliable when time limits increase. See http://symfony.com/doc/current/components/process.html#process-timeout
            $process->setTimeout($time_limit);
            try {
                $process->run();
            }catch (RuntimeException $e){
                // Time Limit Exception
                $run->status = 'TL';
                $run->message = $e->getMessage();
                $run->RMSE = 900;
                $run->save();
                echo "</div><span style='color: red'>Run has been failed because of ". $run->status ."!</span><br>";
                echo "<p><b>Message</b>: " . $run->message . "</p>";
                continue;
            }
            if (!$process->isSuccessful()) {
                // Runtime Error Exception
                $run->status = 'RE';
                $run->message = $process->getOutput() . '<br>' . $process->getErrorOutput();;
                $run->RMSE = 1000;
                $run->save();
                echo "</div><span style='color: red'>Run has been failed because of ". $run->status ."!</span><br>";
                echo "<p><b>Message</b>: " . $run->message . "</p>";
                continue;
            }
            $output = $process->getOutput();
            echo '<textarea class="col-md-4" style="max-height:400px; min-height: 250px;">User output: '. trim($output) . '</textarea></div>';

            // evaluating result of test case
            try {
                $run->RMSE = RunSubmission::getRMSE($output, $tcOutput);
            }
            catch(\Exception $e){
                $run->status = 'WR';
                $run->message = $e->getMessage();
                $run->RMSE = 500;
                $run->save();
                echo "</div><span style='color: red'>Run has been failed because of ". $run->status ."!</span><br>";
                echo "<p><b>Message</b>: " . $run->message . "</p>";
                continue;

            }
            $run->status = 'AC';
            $run->save();

            echo "<span style='color: green'>Run has been done successfully!</span><br>";
            echo "<span style='color: green'>RMSE: " . $run->RMSE . "</span><br>";
        }
        echo '</div>
            <div class="col-md-2 sidenav"></div>
        </div>';
    }

    public static function preJudge(User $team){
        echo '<div class="clearfix"></div>';
        echo '<div class="row content">
                <div class="col-md-2 sidenav"></div>
                    <div class="col-md-8 text-left"> 
                        <button type="button" class="btn btn-info">'. $team->name .'</button>';
        $submit = $team->submits->last();
        $submit->load(['problem', 'attachment']);

        $attachment = $submit->attachment;
        $language = $submit->language;
        $problem = $submit->problem;

        $time_limit = 120; // seconds
        $memory_limit = 200*1024; // kb
        $slug = explode(".", $attachment->real_name)[0];

        // create unique directory in /tmp
        $process = new Process("mktemp -d");
        $process->run();
        if (!$process->isSuccessful()){
            return;
        }
        $tmpDirectory = trim($process->getOutput());
        echo "<p>Temp directory " . $tmpDirectory . "has been created!</p>";

        $context = [
            'tmp_directory' => $tmpDirectory,
            'directory' => $attachment->getWholePath(),
            'problem_slug' => $slug,
            'file_extension' => $language->file_extension,
            'memory_limit' => $memory_limit,
        ];

        // Copy submit file to temp directory
        $source = $context['directory'] . '/' . $attachment->real_name;
        $destination = RunSubmission::contextify('{{ tmp_directory }}/{{ problem_slug }}.{{ file_extension }}', $context);
        $process = new Process("cp ". $source . " " . $destination);
        $process->run();
        if (!$process->isSuccessful()){
            return;
        }
        echo "<p>Submit file " . $source . " has been copied to tmp directory!</p>";


        $status = '';
        // Compile the code (if we need to)
        if ($language->compile_command) {
            $process = new Process(RunSubmission::contextify('mbox -n -i -r {{ tmp_directory }} -C {{ tmp_directory }} -- ' . $language->compile_command, $context));
            $process->run();
            if (!$process->isSuccessful()) {
                $status = 'CE';
                $compileErrorMessage = $process->getErrorOutput();
            }
        }

        // Run the compiled executable for each test case.
        $execute_command = RunSubmission::contextify('(ulimit -v ' . $memory_limit . '; mbox -n -i -r {{ tmp_directory }} -C {{ tmp_directory }} -- ' . $language->execute_command . ')', $context);
        if ($language->file_extension == 'java'){
            $execute_command = RunSubmission::contextify('mbox -n -i -r {{ tmp_directory }} -C {{ tmp_directory }} -- '. $language->execute_command , $context);
        }


        $log = new Log;
        $log->submit_id = $submit->id;
        $log->message = '';
        if ($status == 'CE'){
            // Compile Error Exception
            $log->status = $status;
            $log->message = $compileErrorMessage;
            $log->save();
            echo "</div><span style='color: red'>Run has been failed because of ". $log->status ."!</span><br>";
            echo "<p><b>Message</b>: " . $log->message . "</p>";
            die();
        }

        echo '<hr>';
        $counter = 0;
        $sum = 0;
        // giving inputs to the executable file and getting outputs
        foreach (Sample::with('attachments')->get() as $sample) {
            echo "<h4>Test Case " . $counter++ . ":</h4>";

            // Copy Round Attachment to tmp directory
            $source = $sample->attachments->last()->getWholePath() . '/' . $sample->attachments->last()->real_name;
            $process = new Process("cp ". $source . " " . $tmpDirectory);
            $process->run();
            if (!$process->isSuccessful()){
                return;
            }
            echo "<p>Data file " . $source . " has been copied to tmp directory!</p>";

            $tcInput = File::get($sample->attachments->first()->getRelativePath());
            $tcOutput = File::get($sample->attachments->get(1)->getRelativePath());

            echo '<div class="row">';
            echo '<textarea class="col-md-4" style ="max-height:400px;min-height: 250px;">Run input: '. $tcInput . '</textarea>';
            echo '<textarea class="col-md-4" style ="max-height:400px;min-height: 250px;">Run output: '. $tcOutput . '</textarea>';

            $process = new Process($execute_command);
            $process->setInput($tcInput);
            //FIXME: setTimeout becomes unreliable when time limits increase. See http://symfony.com/doc/current/components/process.html#process-timeout
            $process->setTimeout($time_limit);
            try {
                $process->run();
            }catch (RuntimeException $e){
                // Time Limit Exception
                $log->status = 'TL';
                $log->message = $e->getMessage();
                $log->save();
                echo "</div><span style='color: red'>Run has been failed because of ". $log->status ."!</span><br>";
                echo "<p><b>Message</b>: " . $log->message . "</p>";
                die();
            }
            if (!$process->isSuccessful()) {
                // Runtime Error Exception
                $log->status = 'RE';
                $log->message = $process->getOutput() . '<br>' . $process->getErrorOutput();
                $log->save();
                echo "</div><span style='color: red'>Run has been failed because of ". $log->status ."!</span><br>";
                echo "<p><b>Message</b>: " . $log->message . "</p>";
                die();
            }
            $output = $process->getOutput();
            echo '<textarea class="col-md-4" style="max-height:400px; min-height: 250px;">User output: '. trim($output) . '</textarea></div>';

            // evaluating result of test case
            try {
                $score = RunSubmission::getRMSE($output, $tcOutput);
                $sum += $score;
            }
            catch(\Exception $e){
                $log->status = 'WR';
                $log->message = $e->getMessage();
                $log->save();
                echo "</div><span style='color: red'>Run has been failed because of ". $log->status ."!</span><br>";
                echo "<p><b>Message</b>: " . $log->message . "</p>";
                continue;
            }
            $log->status = 'AC';
            $log->message .= 'sample '. $counter. ' RMSE = ' . $score . '\n';
            $log->save();


            echo "<span style='color: green'>Run has been done successfully!</span><br>";
            echo "<span style='color: green'>RMSE: " . $score . " and Sum of RMSE = " . $sum. "</span><br>";
        }
        /*if ($log->status == 'AC') {
            $log->message .= '<p>Sum of RMSE = ' . $sum . '</p>';
            $log->save();
        }*/


        echo "<span style='color: green'>Sum of RMSE: " . $sum . "</span><br>";
        echo '</div>
            <div class="col-md-2 sidenav"></div>
        </div>';
    }
}