<?php

class DifficultyController extends \BaseController {

	public function index($question_id){
		
		$difficulties = Difficulty::where('question_id',$question_id)->get();
		$weights = VoteController::getUsersWeight();
		
		$sumas = array('1' => 0, '2' => 0, '3' => 0, '4' => 0, '5' => 0);
		$total_weight = 0;

		foreach ($difficulties as $difficulty) {
			$sumas[$difficulty->difficulty] =  $sumas[$difficulty->difficulty] + $weights[$difficulty->user_id]['weight'];
			$total_weight = $total_weight + $weights[$difficulty->user_id]['weight'];
		}

		if($total_weight != 0){
			$sum = 0;
			foreach($sumas as $key => $suma){
				// dd(array($sumas,$suma,($suma/$total_weight)));
				$sum = $sum + $key*($suma/$total_weight);
			}
			$sum = round($sum);
		}else
			$sum = 1;

		return Response::json(array('status' => true,'difficulty' => $sum));
	}

	public function store($question_id){
		DB::beginTransaction();
		try{
			$difficulty = Difficulty::where('question_id',$question_id)->where('user_id',Auth::id())->first();
			if($difficulty){
				$difficulty->difficulty = Input::get('difficulty');
			}
			else{
				$difficulty = new Difficulty;
				$difficulty->difficulty = Input::get('difficulty');
				$difficulty->user_id = Auth::id();
				$difficulty->question_id = $question_id;
			}
			$difficulty->save();
		}catch(Exception $e){
			DB::rollback();
			return Response::json(array('status' => false, 'error' => $e->getMessage()));
		}

		DB::commit();

		$difficulties = Difficulty::where('question_id',$question_id)->get();
		$sum = 0;
		foreach ($difficulties as $difficulty) {
			$sum = $sum + $difficulty->difficulty;
		}
		$num = $sum/count($difficulties);
		if($num == 0){
			$num = 1;
		}
		return Response::json(array('status' => true,'difficulty' => $num));
	}
}