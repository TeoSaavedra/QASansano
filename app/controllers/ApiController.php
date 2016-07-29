<?php

class ApiController extends \BaseController {

	public function questions(){
		$weights = VoteController::getUsersWeight();
		$questions = Question::with('tags')->with('answers')->with('user')->with('difficulties')->get();
		$response = array();
		foreach($questions as $question){
			$tags = array();
			if(Input::has('tag'))
				$_tag_ = false;
			else
				$_tag_ = true;
			if(Input::has('career_id'))
				$_car_ = false;
			else
				$_car_ = true;
			foreach($question->tags as $tag){
				if(!$_tag_) {
					if($tag->tag == Input::get('tag'))
						$_tag_ = true;
				}
				if(!$_car_) {
					if($tag->career_id == Input::get('career_id') || $tag->career_id == null)
						$_car_ = true;
				}
				array_push($tags, array(
					'id' => $tag->id,
					'tag' => $tag->tag,
					'career_id' => $tag->career_id
				));
			}
			$sumas = array('1' => 0, '2' => 0, '3' => 0, '4' => 0, '5' => 0);
			$total_weight = 0;
			foreach ($question->difficulties as $difficulty) {
				$sumas[$difficulty->difficulty] =  $sumas[$difficulty->difficulty] + $weights[$difficulty->user_id]['weight'];
				$total_weight = $total_weight + $weights[$difficulty->user_id]['weight'];
			}
			if($total_weight != 0){
				$sum = 0;
				foreach($sumas as $key => $suma){
					$sum = $sum + $key*($suma/$total_weight);
				}
				$sum = round($sum);
			}else
				$sum = 1;
			
			$answers = array();
			foreach($question->answers as $answer){
				$tmp = array();
				$votes = DB::select('SELECT sum(vote) as vote FROM votes WHERE votes.answer_id = ?',array($answer->id));
				$tmp['id'] = $answer->id;
				$tmp['answer'] = $answer->answer;
				$tmp['created_at'] = date('l d \d\e F \d\e\l Y \a \l\a\s H:i:s',strtotime($answer->created_at));
				$tmp['votes'] = $votes[0]->vote ? $votes[0]->vote : 0;
				$tmp['correct'] = $answer->correct;
				$tmp['user'] = array('id' => $answer->user->id,'name' => $answer->user->name,'lastname' => $answer->user->lastname,'email' => $answer->user->email,'career' => array('id' => $answer->user->career->id, 'code' => $answer->user->career->code, 'name' => $answer->user->career->name));
				array_push($answers,$tmp);
			}
			if(Input::has('user_id')){
				if($question->user->id == intval(Input::get('user_id')))
					$_user_ = true;
				else
					$_user_ = false;
			}
			else
				$_user_ = true; 

			if(Input::has('diff')){
				if($sum == intval(Input::get('diff')))
					$_diff_ = true;
				else
					$_diff_ = false;
			}
			else
				$_diff_ = true; 

			$user = array('id' => $question->user->id,'name' => $question->user->name,'lastname' => $question->user->lastname,'email' => $question->user->email,'career' => array('id' => $question->user->career->id, 'code' => $question->user->career->code, 'name' => $question->user->career->name));

			$tmp = array(
				'id' => $question->id,
				'title' => $question->title,
				'question' => $question->question,
				'created_at' => date('l d \d\e F \d\e\l Y \a \l\a\s H:i:s',strtotime($question->created_at)),
				'difficulty' => $sum,
				'user' => $user,
				'tags' => $tags,
				'answers' => $answers,
			);
			if($_tag_ && $_user_ && $_diff_ && $_car_) 
				array_push($response, $tmp);
		}
		return Response::json($response);
	}

	public function users()
	{
		$users = User::with('career')->get();
		$response = array();
		foreach($users as $user){
			if(Input::has('career_id')){
				if($user->career->id == Input::get('career_id'))
					$_car_ = true;
				else
					$_car_ = false;
			}	
			else
				$_car_ = true;

			$tmp = array('id' => $user->id,'name' => $user->name,'lastname' => $user->lastname,'email' => $user->email,'career' => array('id' => $user->career->id, 'code' => $user->career->code, 'name' => $user->career->name));
			if($_car_)
				array_push($response,$tmp);
		}
		return Response::json($response);
	}

	public function careers()
	{
		if(Input::has('name'))
			$careers = Career::where('name','like', '%'.Input::get('name').'%')->get();
		else
			$careers = Career::get();
		$response = array();
		foreach($careers  as $career){
			$tmp = array('id' => $career->id, 'code' => $career->code, 'name' => $career->name);
			array_push($response,$tmp);
		}
		return Response::json($response);
	}

	public function tags()
	{
		if(Input::has('tag'))
			$tags = Tag::with('career')->where('tag','like', '%'.Input::get('tag').'%')->get();
		else
			$tags = Tag::with('career')->get();
		$response = array();
		foreach($tags  as $tag){
				$tmp = array(
					'id' => $tag->id,
					'tag' => $tag->tag
				);
				if($tag->career){
					$tmp['career'] = array('id' => $tag->career->id, 'code' => $tag->career->code, 'name' => $tag->career->name);
				}else
					$tmp['career'] = null;
				array_push($response,$tmp);	
		}
		return Response::json($response);

	}
}