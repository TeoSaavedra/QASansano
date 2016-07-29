<?php

class AnswerController extends \BaseController {

	public function index($question_id){
		// $answers = DB::table('answers')->where('question_id',$question_id)
		// 				->join('users','answers.user_id','=','users.id')
		// 				->select('answers.id','answers.answer','users.email','answers.user_id','answers.created_at')->get();
		$answers = DB::select('SELECT answers.id, answers.answer ,users.email, answers.user_id, answers.created_at, answers.correct, (SELECT sum(vote) FROM votes WHERE votes.answer_id = answers.id) as votes FROM answers JOIN users ON answers.user_id = users.id WHERE answers.question_id = ?',array($question_id));
		foreach($answers as $answer){
			$answer->created_at = date('l d \d\e F \d\e\l Y \a \l\a\s H:i:s',strtotime($answer->created_at));
			if($answer->votes == null) $answer->votes = 0;
		}
		return Response::json($answers);
	}
	public function store($question_id){
		DB::beginTransaction();
		try{
			$answer = new Answer;
			$answer->answer = Input::get('answer');
			$answer->question_id = $question_id;
			$answer->user_id = Auth::id();
			$answer->save();
		}catch(Exception $e){
			DB::rollback();
			return Response::json(array('status' => false, 'error' => $e));
		}

		DB::commit();

		//hacer que devuelva datos de index
		return Response::json(array('status' => true));
	}
}