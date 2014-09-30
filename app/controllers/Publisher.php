<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Publisher extends Eloquent implements UserInterface, RemindableInterface {
	
	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'comicdb_publishers';

	/**
	 * Only the variables we defined here are changable
	 */
	protected $fillable = array();

	public function comicdb() {
		return $this->belongsTo('id');
	}
}
