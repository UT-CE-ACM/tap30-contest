<?php

namespace App\Utils\Submissions;

use App\Models\Record;
use App\Models\Round;
use App\Models\Run;
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
        echo "********************<br>";
        echo "Winner: " . $record->winner->name . "<br>";
        echo "********************<br>";
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
        return sqrt($result);
    }

    public static function handle(User $team, Round $round){
        echo "=======================================================<br>";
        $submit = $team->submits->last();
        $submit->load(['problem', 'attachment']);
        $submit->runs()->whereRoundId($round->id)->delete();
        echo $team->name . ":<br>";

        $attachment = $submit->attachment;
        $language = $submit->language;
        $problem = $submit->problem;

        $time_limit = 5; // seconds
        $memory_limit = 50*1024; // kb
        $slug = explode(".", $attachment->real_name)[0];

        // create unique directory in /tmp
        $process = new Process("mktemp -d");
        $process->run();
        if (!$process->isSuccessful()){
            return;
        }
        $tmpDirectory = trim($process->getOutput());
        echo "Temp directory " . $tmpDirectory . "has been created!<br>";

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
        echo "Submit file " . $source . " has been copied to tmp directory!<br>";

        // Copy Round Attachment to tmp directory
        $source = $round->attachment->getWholePath() . '/' . $round->attachment->real_name;
        $process = new Process("cp ". $source . " " . $tmpDirectory);
        $process->run();
        if (!$process->isSuccessful()){
            return;
        }
        echo "Data file " . $source . " has been copied to tmp directory!<br>";

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

        $counter = 1;
        echo "<pre>";
        // giving inputs to the executable file and getting outputs
        foreach ($round->test_cases as $test_case) {
            echo "Test Case " . $counter++ . ":<br>";
            $test_case->load('attachments');
            $tcInput = File::get($test_case->attachments->first()->getRelativePath());
            $tcOutput = File::get($test_case->attachments->last()->getRelativePath());

            echo "\tRun input: ". $tcInput . "<br>";
            echo "\tRun output: ". $tcOutput . "<br>";

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
                echo "\t<span style='color: red'>Run has been failed because of ". $run->status ."!</span><br>";
                echo "\tMessage: " . $run->message . "<br>";
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
                echo "\t<span style='color: red'>Run has been failed because of ". $run->status ."!</span><br>";
                echo "\tMessage: " . $run->message . "<br>";
                continue;
            }
            if (!$process->isSuccessful()) {
                // Runtime Error Exception
                $run->status = 'RE';
                $run->message = $process->getErrorOutput();;
                $run->RMSE = 1000;
                $run->save();
                echo "\t<span style='color: red'>Run has been failed because of ". $run->status ."!</span><br>";
                echo "\tMessage: " . $run->message . "<br>";
                continue;
            }
            $output = $process->getOutput();
            echo "\tUser output: " . trim($output) . "<br>";

            // evaluating result of test case
            $run->RMSE = RunSubmission::getRMSE($output, $tcOutput);
            $run->status = 'AC';
            $run->save();

            echo "\t<span style='color: green'>Run has been done successfully!</span><br>";
        }
        echo "</pre>";

    }
}