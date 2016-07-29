<?php

class Question extends Eloquent{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'questions';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */

	public function tags()
	{
		return $this->belongsToMany('Tag');
	}

	public function user()
	{
		return $this->belongsTo('User');
	}

	public function answers()
	{
		return $this->hasMany('Answer');
	}

	public function difficulties()
	{
		return $this->hasMany('Difficulty');
	}

}
