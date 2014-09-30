<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Comicdb extends Eloquent implements UserInterface, RemindableInterface {
	
	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'comicdb';

	/**
	 * Only the variables we defined here are changable
	 */
	protected $fillable = array();

	public function publisher() {
		return $this->hasOne('Publisher'); // this matches the Eloquent model
	}

	public function author() {
		return $this->hasOne('Authors'); // this matches the Eloquent model
	}
}
