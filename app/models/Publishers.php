<?php

//Publisher model

class Publishers extends Eloquent {

	protected $table = 'comicdb_publishers';

	//Get Publisher info
	public function scopeFindPublisher($publisher)
	{
		return $query->where('publisher_name', '=', $publisher);
	}
}