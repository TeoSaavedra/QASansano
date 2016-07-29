<?php

class QuestionController extends \BaseController {

	public function index()
	{
		// App::make('VoteController')->getUsersWeight();
		$weights = VoteController::getUsersWeight();
		$questions = Question::with('tags')->with('answers')->with('user')->with('difficulties')->get();
		$response = array();
		foreach($questions as $question){
			$tags = array();
			foreach($question->tags as $tag){
				array_push($tags, array(
					'id' => $tag->id,
					'tag' => $tag->tag,
					'career_id' => $tag->career_id
				));
			}
			$sumas = array('1' => 0, '2' => 0, '3' => 0, '4' => 0, '5' => 0);
			$total_weight = 0;
			foreach ($question->difficulties as $difficulty) {
				// $sum = $sum + $difficulty->difficulty;
				// dd($weights[$difficulty->user_id]['weight']);
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
			
			$tmp = array(
				'id' => $question->id,
				'title' => $question->title,
				'user' => $question->user->email,
				'created_at' => date('l d \d\e F \d\e\l Y \a \l\a\s H:i:s',strtotime($question->created_at)),
				'answers' => count($question->answers),
				'tags' => $tags,
				'difficulty' => $sum
			);
			array_push($response, $tmp);
		}
		return Response::json($response);
	}

	

	public function create()
	{
		//
		$careers = Career::all();
		return View::make('questions.create')->with('careers',$careers);
	}

	public function store(){
		DB::beginTransaction();
		try{
			$question = new Question;
			$question->question = Input::get('question');
			$question->title = Input::get('title');
			$question->user_id = Auth::id();
			$question->save();
 			$tags = array_map('intval',explode(",",Input::get('tags')));
			$question->tags()->attach($tags);
		}catch(Exception $e){
			DB::rollback();
		}

		DB::commit();
		return Redirect::route('questions.show',$question->id);
	}

	public function show($id)
	{	
		$question = Question::find($id);
		$user = $question->user;
		$data_user = array('email' => $user->email,'id' => $user->id);
		$tags = $question->tags;
		return View::make('questions.show')->with('question',$question)->with('tags',$tags)->with('user',$data_user);
	}

}
