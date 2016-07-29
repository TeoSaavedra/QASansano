<?php

class Career extends Eloquent{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'careers';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */

	public function tags()
	{
		return $this->hasMany('Tag');
	}


}
