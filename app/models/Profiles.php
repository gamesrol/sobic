<?php

/**
 * Profile Model
 */

class Profile extends \Illuminate\Database\Eloquent\Model
{
	protected $table = "profiles";
	protected $fillable = ['user_id','title','name','surname','dateBirth','phoneNumber','address','postalCode','city','country','summary','linkedin'];
}