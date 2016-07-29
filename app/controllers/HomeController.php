<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{	
		$careers = Career::all();
		return View::make('home')->with('careers',$careers);
	}

	public function testLogin()
	{

		if(Auth::validate(array('email' => Input::get('email'), 'password' => Input::get('password'))))
			return Response::json(array('success' => true));
		else
			return Response::json(array('success' => false));

	}

	public function login(){
		if (Auth::attempt(array('email' => Input::get('email'), 'password' => Input::get('password')), true))
			return  Redirect::route('home');
	}

	public function logout(){
		Auth::logout();
		return  Redirect::route('home');
	}


}
