<?php

/**
 * Prueba Model
 */

class Prueba extends \Illuminate\Database\Eloquent\Model
{
	protected $table = "pruebas";
	protected $fillable = ['name','hola'];
}