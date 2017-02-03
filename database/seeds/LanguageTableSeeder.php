<?php

use Illuminate\Database\Seeder;

class LanguageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear languages table.
        DB::table('languages')->delete();

        DB::table('languages')->insert([
            [
                'name' => 'C99',
                'version' => 'gcc 5.3.1',
                'compile_command' => 'gcc -std=gnu99 -O2 -lm -DONLINE_JUDGE -o {{ problem_slug }} {{ problem_slug }}.c',
                'execute_command' => './{{ problem_slug }}',
                'file_extension' => 'c',
            ],
            [
                'name' => 'C11',
                'version' => 'gcc 5.3.1',
                'compile_command' => 'gcc -std=gnu11 -O2 -lm -DONLINE_JUDGE -o {{ problem_slug }} {{ problem_slug }}.c',
                'execute_command' => './{{ problem_slug }}',
                'file_extension' => 'c',
            ],
            [
                'name' => 'C++99',
                'version' => 'g++ 5.3.1',
                'compile_command' => 'g++ -std=c++98 -O2 -DONLINE_JUDGE -o {{ problem_slug }} {{ problem_slug }}.cpp',
                'execute_command' => './{{ problem_slug }}',
                'file_extension' => 'cpp',
            ],
            [
                'name' => 'C++11',
                'version' => 'g++ 5.3.1',
                'compile_command' => 'g++ -std=c++11 -O2 -DONLINE_JUDGE -o {{ problem_slug }} {{ problem_slug }}.cpp',
                'execute_command' => './{{ problem_slug }}',
                'file_extension' => 'cpp',
            ],
            [
                'name' => 'C++14',
                'version' => 'g++ 5.3.1',
                'compile_command' => 'g++ -std=c++14 -O2 -DONLINE_JUDGE -o {{ problem_slug }} {{ problem_slug }}.cpp',
                'execute_command' => './{{ problem_slug }}',
                'file_extension' => 'cpp',
            ],
            [
                'name' => 'Java 8',
                'version' => 'OpenJDK javac 1.8.0_91',
                'compile_command' => 'javac {{ problem_slug }}.java',
                'execute_command' => 'java {{ problem_slug }}',
                'file_extension' => 'java',
            ],
            [
                'name' => 'Python 2',
                'version' => 'python 2.7.11+',
                'compile_command' => '',
                'execute_command' => 'python2.7 {{ problem_slug }}.py',
                'file_extension' => 'py',
            ],
            [
                'name' => 'Python 3',
                'version' => 'python 3.5.1+',
                'compile_command' => '',
                'execute_command' => 'python3.5 {{ problem_slug }}.py',
                'file_extension' => 'py',
            ],
        ]);
    }
}
