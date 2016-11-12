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


Route::get('/', function () {
    return redirect('home');
});


Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('projects/{project}/voters/{voter}',['as' => 'projects.voters', 'uses' => 'ProjectVoterController@voterSurvey']);

Route::post('projects/{project}/voters/{voter}',['as' => 'projects.voters.create', 'uses' => 'ProjectVoterController@createVoterSurveyResult']);

Route::match(['put', 'patch'],'projects/{project}/voters/{voter}',['as' => 'projects.voters.update', 'uses' => 'ProjectVoterController@updateVoterSurveyResult']);

Route::resource('projects', 'ProjectController');

Route::resource('questions', 'QuestionController');

Route::get('voters/search',[ 'as' => 'voters.search', 'uses'=>'VoterController@search']);

Route::resource('voters', 'VoterController');