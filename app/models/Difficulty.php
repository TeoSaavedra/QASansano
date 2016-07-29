<?php

class Difficulty extends Eloquent{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'difficulties';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */

	public function question()
	{
		return $this->belongsTo('Question');
	}

	public function user()
	{
		return $this->belongsTo('User');
	}


}
