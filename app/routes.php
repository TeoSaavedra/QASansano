<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', array(
	'as' => 'home',
	'uses' => 'HomeController@showWelcome'
));

Route::post('login', array(
	'as' => 'login',
	'uses' => 'HomeController@login'
));

Route::post('login/test',array(
	'as' => 'login_test',
	'uses' => 'HomeController@testLogin'
));

Route::get('register', array(
	'as' => 'register',
	'uses' => 'UserController@create'
));

Route::get('logout', array(
	'as' => 'logout',
	'uses' => 'HomeController@logout'
));

Route::resource('users', 'UserController');

// Tags Routes
Route::get('tags', array(
	'as' => 'tags.index',
	'uses' => 'TagController@index'
));
Route::get('tags/test', array(
	'as' => 'tag_test',
	'uses' => 'TagController@testStore'
));
Route::post('tags/store', array(
	'before' => 'auth',
	'as' => 'tags.store',
	'uses' => 'TagController@store'
));

// Career Routes
Route::resource('careers', 'CareerController');

Route::get('questions/create',array(
	'before' => 'auth',
	'as' => 'questions.create',
	'uses' => 'QuestionController@create'
));

// Question Routes
Route::get('questions',array(
	'as' => 'questions.index',
	'uses' => 'QuestionController@index'
));
Route::post('questions/store',array(
	'before' => 'auth',
	'as' => 'questions.store',
	'uses' => 'QuestionController@store'
));
Route::get('questions/{id}',array(
	'as' => 'questions.show',
	'uses' => 'QuestionController@show'
));

// Answer Routes
Route::get('questions/{id}/answers',array(
	'as' => 'answers.index',
	'uses' => 'AnswerController@index'
));

Route::post('questions/{id}/answers',array(
	'before' => 'auth',
	'as' => 'answers.store',
	'uses' => 'AnswerController@store'
));

// Difficulty Routes
Route::get('questions/{id}/difficulty',array(
	'as' => 'difficulty.store',
	'uses' => 'DifficultyController@index'
));
Route::post('questions/{id}/difficulty',array(
	'before' => 'auth',
	'as' => 'difficulty.store',
	'uses' => 'DifficultyController@store'
));

Route::post('answers/{id}/vote',array(
	'before' => 'auth',
	'as' => 'vote.store',
	'uses' => 'VoteController@store'
));

Route::get('votes',array(
	'as' => 'votes',
	'uses' => 'VoteController@getUsersWeight'
));

Route::post('answers/{id}/correct',array(
	'before' => 'auth',
	'as' => 'vote.correct',
	'uses' => 'VoteController@correct'
));


Route::group(array('prefix' => 'api'), function() {
	Route::get('questions','ApiController@questions');
	Route::get('users','ApiController@users');
	Route::get('careers','ApiController@careers');
	Route::get('tags','ApiController@tags');
});