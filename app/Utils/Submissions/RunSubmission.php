<?php

namespace App\Utils\Submissions;

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
        $runs = $team->submits>last()->runs()->whereRoundId($round->id);
        foreach($runs as $run){
            $result += $run->RMSE;
        }
        return $result;
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
        $submit = $team->submits->last();
        $submit->load(['problem', 'attachment']);

        $attachment = $submit->attachment;
        $language = $submit->language;
        $problem = $submit->problem;

        $time_limit = 5; // seconds
        $memory_limit = 50*1024; // kb
        $slug = "tap30-problem-".$team->username;

        // create unique directory in /tmp
        $process = new Process("mktemp -d");
        $process->run();
        if (!$process->isSuccessful()){
            return;
        }
        $tmpDirectory = trim($process->getOutput());


        $context = [
            'tmp_directory' => $tmpDirectory,
            'directory' => $attachment->getWholePath(),
            'problem_slug' => $slug,
            'file_extension' => $language->file_extension,
            'memory_limit' => $problem->memory_limit,
        ];

        // Write the code to a file.
        $address = $context['directory'] . '/' . $attachment->real_name;
        $destination = RunSubmission::contextify('{{ tmp_directory }}/{{ problem_slug }}.{{ file_extension }}', $context);
        $process = new Process("cp ". $address . " " . $destination);
        $process->run();
        if (!$process->isSuccessful()){
            return;
        }

        // Compile the code (if we need to)
        if ($language->compile_command) {
            $process = new Process(RunSubmission::contextify('mbox -n -i -r {{ tmp_directory }} -C {{ tmp_directory }} -- ' . $language->compile_command, $context));
            $process->run();
            if (!$process->isSuccessful()) {
                $status = 'CE';
                $compileErrorMessage = $process->getErrorOutput();
                //$this->submission->verdict = 'CE';
            }
        }

        // Run the compiled executable for each test case.
        $execute_command = RunSubmission::contextify('(ulimit -v ' . $memory_limit . '; mbox -n -i -r {{ tmp_directory }} -C {{ tmp_directory }} -- ' . $language->execute_command . ')', $context);

        // giving inputs to the executable file and getting outputs
        foreach ($round->test_cases as $test_case) {
            $test_case->load('attachments');
            $tcInput = File::get($test_case->attachments->first()->getRelativePath());
            $tcOutput = File::get($test_case->attachments->last()->getRelativePath());
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
                continue;
            }
            if (!$process->isSuccessful()) {
                // Runtime Error Exception
                $run->status = 'RE';
                $run->message = $process->getErrorOutput();;
                $run->RMSE = 1000;
                $run->save();
                continue;
            }
            $output = $process->getOutput();

            // evaluating result of test case
            $run->RMSE = RunSubmission::getRMSE($output, $tcOutput);
            $run->status = 'AC';

            $run->save();
        }
    }
}