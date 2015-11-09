<?php

/**
 * UsersRec Model
 */

class UsersRec extends \Illuminate\Database\Eloquent\Model
{
	protected $table = "usersReco";
	protected $fillable = ['user_id','email','pass','key'];
	
	protected $hidden = array('pass');

	public function userReco() {
		return $this->hasMany('User');
	}
}