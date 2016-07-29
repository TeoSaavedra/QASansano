<?php

class UserController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{	
		$careers = Career::all();
		return View::make('users.create')->with('careers',$careers);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$user = new User;
        $user->name = Input::get('fname');
        $user->lastname = Input::get('lname');
        $user->email = Input::get('email');
        $user->career_id = Input::get('career_id');
        $user->password = Hash::make(Input::get('passwd'));
        $user->save();


        // $user_data = array('email' => Input::get('email'),'password' => Input::get('passwd'));
		if (Auth::login($user))
			return  Redirect::route('home');
		else
			return Redirect::route('home');

	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
