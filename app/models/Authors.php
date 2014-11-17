<?php

class Authors extends \Eloquent {
	protected $fillable = [];

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'comicdb_authors';

	public function issues()
    {
        return $this->hasMany('Comicissues', 'author_id_FK', 'id');
    }
}