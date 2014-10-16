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

	// public function scopeLatest($query){
	// 	return $query->join('comicdb_books', 'comicdb_books.id', '=', 'comicdb.book_id')
	// 				 ->join('comicdb_issues', 'comicdb_issues.book_id', '=', 'comicdb.book_id')
	// 				 ->join('comicdb_artists', 'comicdb_artists.id', '=', 'comicdb.artist_id_FK')
	// 				 ->join('comicdb_authors', 'comicdb_authors.id', '=', 'comicdb.author_id_FK')
	// 				 ->join('comicdb_genre', 'comicdb_genre.id', '=', 'comicdb.genre_id_FK')
	// 				 ->join('comicdb_publishers', 'comicdb_publishers.id', '=', 'comicdb.publisher_id_FK')
	// 				 ->orderBy('comicdb_issues.published_date', 'desc')
	// 				 ->groupBy('comicdb.book_id', 'comicdb.issue_id', 'summary', 'cover_image')
	// 				 ->take(3);
	// }

	// public function scopeSeries($query, $issue) {
	// 	return $query->join('comicdb_books', 'comicdb_books.id', '=', 'comicdb.book_id')
	// 				 ->join('comicdb_issues', 'comicdb_issues.book_id', '=', 'comicdb.book_id')
	// 				 ->join('comicdb_genre', 'comicdb_genre.id', '=', 'comicdb.genre_id_FK')
	// 				 ->join('comicdb_publishers', 'comicdb_publishers.id', '=', 'comicdb.publisher_id_FK')
	// 				 ->where('comicdb_books.book_name', '=', $issue);
	// }

	public function scopeIssues($query, $title, $issues) {
		return $query->join('comicdb_books', 'comicdb_books.id', '=', 'comicdb.book_id')
					 ->join('comicdb_issues', 'comicdb_issues.book_id', '=', 'comicdb.book_id')
					 ->join('comicdb_artists', 'comicdb_artists.id', '=', 'comicdb.artist_id_FK')
					 ->join('comicdb_authors', 'comicdb_authors.id', '=', 'comicdb.author_id_FK')
					 ->join('comicdb_genre', 'comicdb_genre.id', '=', 'comicdb.genre_id_FK')
					 ->join('comicdb_publishers', 'comicdb_publishers.id', '=', 'comicdb.publisher_id_FK')
					 ->where('comicdb_books.book_name', '=', $title)
					 ->where('comicdb_issues.issue_id', '=', $issues)
					 ->where('comicdb.issue_id', '=', $issues);
	}

	public function scopeIssueGenre($query, $title, $issue){
		return $query->join('comicdb_books', 'comicdb_books.id', '=', 'comicdb.book_id')
					 ->join('comicdb_genrebook', 'comicdb_books.id', '=', 'comicdb_genrebook.book_id_FK')
					 ->join('comicdb_genre', 'comicdb_genre.id', '=', 'comicdb_genrebook.genre_id_FK')
					 ->where('book_name', '=', $title)
					 ->select('genre_name');
	}

	public function scopeBookCharacters($query, $title){
		return $query->join('comicdb_books', 'comicdb_books.id', '=', 'comicdb.book_id')
					 ->join('comicdb_issues', 'comicdb_issues.book_id', '=', 'comicdb.book_id')
					 ->join('comicdb_characterbook', 'comicdb_characterbook.book_id_FK', '=', 'comicdb_books.id')
					 ->join('comicdb_characters', 'comicdb_characters.id', '=', 'comicdb_characterbook.character_id_FK')
					 ->where('book_name', '=', $title);
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
					 ->join('comicdb_genrebook', 'comicdb_books.id', '=', 'comicdb_genrebook.book_id_FK')
					 ->join('comicdb_genre', 'comicdb_genre.id', '=', 'comicdb_genrebook.genre_id_FK')
					 ->where('genre_name', '=', $genre);	
	}

	public function scopeYears($query, $year) {
		return $query->join('comicdb_books', 'comicdb_books.id', '=', 'comicdb.book_id')
					 ->join('comicdb_issues', 'comicdb_issues.book_id', '=', 'comicdb.book_id')
					 ->where(DB::raw('year(published_date)'), '=', $year);

	}

	public function scopeCharacters($query, $character){
		return $query->join('comicdb_books', 'comicdb_books.id', '=', 'comicdb.book_id')
					 ->join('comicdb_issues', 'comicdb_issues.book_id', '=', 'comicdb.book_id')
					 ->join('comicdb_characterbook', 'comicdb_characterbook.book_id_FK', '=', 'comicdb_books.id')
					 ->join('comicdb_characters', 'comicdb_characters.id', '=', 'comicdb_characterbook.character_id_FK')
					 ->where('character_name', '=', $character);
	}
}
