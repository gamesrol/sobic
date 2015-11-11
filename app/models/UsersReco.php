<?php

/**
 * UsersRec Model
 */

class UsersRec extends \Illuminate\Database\Eloquent\Model
{
	protected $table = "usersReco";
	protected $fillable = ['user_id','email','key_token'];
	
	public function userReco() {
		return $this->hasMany('User');
	}
}