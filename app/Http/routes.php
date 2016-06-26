<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/crawl',
	['as' => 'start.crawl',
	'uses' => 'WelcomeController@index']);


// Route::resource('crawl','WelcomeController@index');
Route::resource('download','WelcomeController@download');
