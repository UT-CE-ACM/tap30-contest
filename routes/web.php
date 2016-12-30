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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

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

        // attachments management
        Route::any('attachment/remove/{id}', 'AttachmentController@remove');

        // admin index view
        Route::get('/', function (){
            return view('admin.index');
        });
    }
);