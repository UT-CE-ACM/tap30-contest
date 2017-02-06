<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
use Illuminate\Support\Facades\Route;

/*Route::get('/create-test-users', function (){
    for ($i=1 ; $i<=63; $i ++){
        $name = str_random(5);
        \App\Models\User::create([
            'name' => 'UT '.$name,
            'username' => $name,
            'password' => '1',
            'is_admin' => false
        ]);
        echo $i . '. '. $name . ' created!<br>';
    }
    echo 'Transactions are done!';
});*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::post('/problem/{id}/submit', 'SubmitController@store');
Route::delete('/submit/{id}/remove', 'SubmitController@destroy');

Route::group(
    [
        'prefix' => 'admin',
        'middleware' => 'admin'
    ],
    function (){
        // resources routing
        Route::resource('problem', 'ProblemController');
        Route::resource('sample', 'SampleController');
        Route::resource('user', 'UserController');
        Route::resource('submit', 'SubmitController');
        Route::resource('timer', 'TimerController');
        Route::resource('round', 'RoundController');
        Route::resource('test-case', 'TestCaseController');

        // attachments management
        Route::any('attachment/remove/{id}', 'AttachmentController@remove');

        // admin index view
        Route::get('/', function (){
            return view('admin.index');
        });
    }
);