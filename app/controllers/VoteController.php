<?php

class VoteController extends \BaseController {

	public function store($answer_id){
		DB::beginTransaction();
		try{
			$vote = Vote::where('answer_id',$answer_id)->where('user_id',Auth::id())->first();
			if($vote){
				$vote->vote = Input::get('vote');
			}else{
				$vote = new Vote;
				$vote->vote = intval(Input::get('vote'));
				$vote->answer_id = $answer_id;
				$vote->user_id = Auth::id();
			}
			$vote->save();
		}catch(Exception $e){
			DB::rollback();
			return Response::json(array('status' => false, 'error' => $e->getMessage()));
		}

		DB::commit();
		return Response::json(array('status' => true));
	}

	public function getUsersWeight(){
		$votes = DB::select('SELECT users.id, (SELECT IFNULL(SUM(vote),0) FROM votes JOIN answers ON answers.id = votes.answer_id WHERE answers.user_id = users.id) as vote FROM users ORDER BY vote ASC');
		$response = array();
		// $votes = array();
		// for ($i=-50; $i < 50; $i++) { 
		// 	array_push($votes, rand(-80,100));
		// }
		// asort($votes);
		$total = count($votes);
		$percent = ceil(80*$total/100);
		$index = 1;
		foreach ($votes as $vote) {
			if($index >= $percent)
				$weight = 1;
			else
				$weight = ($index)*((1-0.01)/floatval($percent-1));

			$response[$vote->id] = array('vote' => $vote->vote, 'weight' => $weight);
			// $response[$index] = array('vote' => $vote, 'weight' => $weight);
			$index = $index + 1;
		}
		return $response;
		// dd($response);

	}

	public function correct($answer_id){
		DB::beginTransaction();
		try{
			$answer = Answer::find($answer_id);
			$answer->correct = 1;
			$question_id = $answer->question_id;
			$old = Answer::where('question_id',$question_id)->where('correct',1)->first();
			$old->correct = NULL;
			$old->save();
			$answer->save();
		}catch(Exception $e){
			DB::rollback();
			return Response::json(array('status' => false, 'error' => $e->getMessage()));
		}

		DB::commit();
		return Response::json(array('status' => true));
	}
}

