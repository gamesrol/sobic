<?php 
/**
 * User Model
 */


class User extends \Illuminate\Database\Eloquent\Model
{
	protected $table = "users";
	
	protected $hidden = array('password');
	
	/*
		Example of relations:
		---------------------
		
		public function questions() {
			return $this->hasMany('Questions');
		}
	
		public function personal() {
			return $this->hasOne('Personal');
		}
		
		public function job() {
			return $this->belongsTo('Job');
		}
	*/
}
