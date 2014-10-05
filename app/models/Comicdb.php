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

	public function scopeLatest($query){
		return $query->join('comicdb_books', 'comicdb_books.id', '=', 'comicdb.book_id')
					 ->join('comicdb_issues', 'comicdb_issues.issue_id', '=', 'comicdb.issue_id')
					 ->join('comicdb_artists', 'comicdb_artists.id', '=', 'comicdb.artist_id_FK')
					 ->join('comicdb_authors', 'comicdb_authors.id', '=', 'comicdb.author_id_FK')
					 ->join('comicdb_genre', 'comicdb_genre.id', '=', 'comicdb.genre_id_FK')
					 ->join('comicdb_publishers', 'comicdb_publishers.id', '=', 'comicdb.publisher_id_FK')
					 ->orderBy('comicdb_issues.published_date', 'desc')->take(3);
	}

	public function scopeSeries($query, $issue) {
		return $query->join('comicdb_books', 'comicdb_books.id', '=', 'comicdb.book_id')
					 ->join('comicdb_issues', 'comicdb_issues.issue_id', '=', 'comicdb.issue_id')
					 ->join('comicdb_artists', 'comicdb_artists.id', '=', 'comicdb.artist_id_FK')
					 ->join('comicdb_authors', 'comicdb_authors.id', '=', 'comicdb.author_id_FK')
					 ->join('comicdb_genre', 'comicdb_genre.id', '=', 'comicdb.genre_id_FK')
					 ->join('comicdb_publishers', 'comicdb_publishers.id', '=', 'comicdb.publisher_id_FK')
					 ->where('comicdb_books.book_name', '=', $issue)->take(1);
	}

	public function scopeAuthors($query, $author){
		return $query->join('comicdb_books', 'comicdb_books.id', '=', 'comicdb.book_id')
					 ->join('comicdb_issues', 'comicdb_issues.book_id', '=', 'comicdb.book_id')
					 ->join('comicdb_authors', 'comicdb_authors.id', '=', 'comicdb.author_id_FK')
					 ->where('comicdb_authors.author_name', '=', $author);
	}

	public function scopeArtists($query, $artist){
		return $query->join('comicdb_books', 'comicdb_books.id', '=', 'comicdb.book_id')
					 ->join('comicdb_issues', 'comicdb_issues.book_id', '=', 'comicdb.book_id')
					 ->join('comicdb_artists', 'comicdb_artists.id', '=', 'comicdb.artist_id_FK')
					 ->where('artist_name', '=', $artist);
	}

	public function scopePublishers($query, $publisher){
		return $query->join('comicdb_books', 'comicdb_books.id', '=', 'comicdb.book_id')
					 ->join('comicdb_issues', 'comicdb_issues.book_id', '=', 'comicdb.book_id')
					 ->join('comicdb_publishers', 'comicdb_publishers.id', '=', 'comicdb.publisher_id_FK')
					 ->where('comicdb_publishers.publisher_name', '=', $publisher);
	}

	public function scopeGenres($query, $genre){
		return $query->join('comicdb_books', 'comicdb_books.id', '=', 'comicdb.book_id')
					 ->join('comicdb_issues', 'comicdb_issues.book_id', '=', 'comicdb.book_id')
					 ->join('comicdb_genre', 'comicdb_genre.id', '=', 'comicdb.genre_id_FK')
					 ->where('comicdb_genre.genre_name', '=', $genre);
	}

	public function scopeYears($query, $year) {
		return $query->join('comicdb_books', 'comicdb_books.id', '=', 'comicdb.book_id')
					 ->join('comicdb_issues', 'comicdb_issues.book_id', '=', 'comicdb.book_id')
					 ->where(DB::raw('year(published_date)'), '=', $year);

	}
}
