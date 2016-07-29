<?php

class Vote extends Eloquent{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'votes';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */

	public function answer()
	{
		return $this->belongsTo('Answer');
	}

	public function user()
	{
		return $this->belongsTo('User');
	}

}
