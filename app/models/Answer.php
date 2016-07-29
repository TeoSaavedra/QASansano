<?php

class Answer extends Eloquent{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'answers';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */

	public function question()
	{
		return $this->belongsTo('Question');
	}

	public function votes()
	{
		return $this->hasMany('Vote');
	}

	public function user()
	{
		return $this->belongsTo('User');
	}


}
