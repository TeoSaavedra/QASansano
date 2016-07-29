<?php

class CareerController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		$careers = array();
		foreach(Career::get() as $career){
			array_push($careers,array('id' => $career->id , 'name' => $career->name." (".$career->code.")"));
		}
		return Response::json($careers);

	}

}