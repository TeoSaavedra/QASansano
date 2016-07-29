<?php

class Tag extends Eloquent{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tags';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	public function career()
	{
		return $this->belongsTo('Career');
	}

	public function questions()
	{
		return $this->belongsToMany('Questions');
	}

}