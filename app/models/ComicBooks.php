<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Comicbooks extends Eloquent implements UserInterface, RemindableInterface {
	
	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'comicdb_books';

	/**
	 * Only the variables we defined here are changable
	 */
	protected $fillable = array();

	public function scopeLatest($query){
		return $query->join('comicdb_issues', 'comicdb_issues.book_id', '=', 'comicdb_books.id')
					 ->orderBy('comicdb_issues.published_date', 'desc')
					 ->take(3);
	}

	public function scopeSeries($query, $book){
		return $query->join('comicdb_issues', 'comicdb_issues.book_id', '=', 'comicdb_books.id')
					 ->join('comicdb_genrebook', 'comicdb_books.id', '=', 'comicdb_genrebook.book_id_FK')
					 ->join('comicdb_genre', 'comicdb_genre.id', '=', 'comicdb_genrebook.genre_id_FK')
					 ->join('comicdb_publishers', 'comicdb_publishers.id', '=', 'comicdb_books.publisher_id_FK')
					 ->where('book_name', '=', $book);	
	}
}
