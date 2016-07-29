<?php

class TagController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		return Response::json(Tag::get(array('id','tag','career_id')));

	}

	public function testStore()
	{	
		$tag = strtolower(Input::get('tag'));
		$career_id = Input::get('career');
		$response = DB::select('SELECT * FROM tags WHERE (career_id = ? AND tag = ?) OR (career_id IS NULL AND tag = ?)',array($career_id,$tag,$tag));
		if(count($response) > 0)
			return Response::json(array('status' => false));
		else
			return Response::json(array('status' => true));
	}

	public function store()
	{
		DB::beginTransaction();
		try{
			$tag = new Tag;
			$tag->tag = strtolower(Input::get('tag'));
			$career_id = intval(Input::get('career'));
			if($career_id != 0){
				$tag->career_id = $career_id;
			}
			$tag->save();
		}catch(Exception $e){
			DB::rollback();
			return Response::json(array('status' => false, 'error' => $e));
		}

		DB::commit();
		return Response::json(array('status' => true, 'tag' => array('id' => $tag->id,'tag' => $tag->tag, 'career_id' => $tag->career_id)));
	}

}