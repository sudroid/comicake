<?php


class Publishers extends Eloquent {

	protected $table = 'comicdb_publishers';

	public function comicbook() {
		return $this->hasOne('Comicbooks', 'publisher_id_FK', 'id');
	} 

	public function scopeFindPublisher($publisher)
	{
		return $query->where('publisher_name', '=', $publisher);
	}
}