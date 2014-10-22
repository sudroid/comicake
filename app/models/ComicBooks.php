<?php

class Comicbooks extends Eloquent {

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
					 ->take(4);
	}

	public function scopeSeries($query, $book){
		return $query->join('comicdb_issues', 'comicdb_issues.book_id', '=', 'comicdb_books.id')
					 ->join('comicdb_genrebook', 'comicdb_books.id', '=', 'comicdb_genrebook.book_id_FK')
					 ->join('comicdb_genre', 'comicdb_genre.id', '=', 'comicdb_genrebook.genre_id_FK')
					 ->join('comicdb_publishers', 'comicdb_publishers.id', '=', 'comicdb_books.publisher_id_FK')
					 ->where('book_name', '=', $book);	
	}

	public function scopeIssues($query, $title, $issue)
	{
		return $query->join('comicdb_issues', 'comicdb_issues.book_id', '=', 'comicdb_books.id')
					 ->join('comicdb_artists', 'comicdb_artists.id', '=', 'comicdb_issues.artist_id_FK')
					 ->join('comicdb_authors', 'comicdb_authors.id', '=', 'comicdb_issues.author_id_FK')
					 ->join('comicdb_publishers', 'comicdb_publishers.id', '=', 'comicdb_books.publisher_id_FK')
					 ->where('comicdb_books.book_name', '=', $title)
					 ->where('comicdb_issues.issue_id', '=', $issue);
	}

	public function scopeIssueGenre($query, $title, $issue){
		return $query->join('comicdb_genrebook', 'comicdb_books.id', '=', 'comicdb_genrebook.book_id_FK')
					 ->join('comicdb_genre', 'comicdb_genre.id', '=', 'comicdb_genrebook.genre_id_FK')
					 ->where('book_name', '=', $title)
					 ->select('genre_name');
	}

	public function scopeBookCharacters($query, $title){
		return $query->join('comicdb_issues', 'comicdb_issues.book_id', '=', 'comicdb_books.id')
					 ->join('comicdb_characterbook', 'comicdb_characterbook.book_id_FK', '=', 'comicdb_books.id')
					 ->join('comicdb_characters', 'comicdb_characters.id', '=', 'comicdb_characterbook.character_id_FK')
					 ->where('book_name', '=', $title);
	}

	public function scopeCharacters($query, $character){
		return $query->join('comicdb_issues', 'comicdb_issues.book_id', '=', 'comicdb_books.id')
					 ->join('comicdb_characterbook', 'comicdb_characterbook.book_id_FK', '=', 'comicdb_books.id')
					 ->join('comicdb_characters', 'comicdb_characters.id', '=', 'comicdb_characterbook.character_id_FK')
					 ->where('character_name', '=', $character);
	}

	public function scopeAuthors($query, $author){
		return $query->join('comicdb_issues', 'comicdb_issues.book_id', '=', 'comicdb_books.id')
					 ->join('comicdb_authors', 'comicdb_authors.id', '=', 'comicdb_issues.author_id_FK')
					 ->where('comicdb_authors.author_name', '=', $author);
	}

	public function scopeArtists($query, $artist){
		return $query->join('comicdb_issues', 'comicdb_issues.book_id', '=', 'comicdb_books.id')
					 ->join('comicdb_artists', 'comicdb_artists.id', '=', 'comicdb_issues.artist_id_FK')
					 ->where('artist_name', '=', $artist);
	}

	public function scopePublishers($query, $publisher){
		return $query->join('comicdb_issues', 'comicdb_issues.book_id', '=', 'comicdb_books.id')
					 ->join('comicdb_publishers', 'comicdb_publishers.id', '=', 'comicdb_books.publisher_id_FK')
					 ->where('comicdb_publishers.publisher_name', '=', $publisher);
	}

	public function scopeGenres($query, $genre){
		return $query->join('comicdb_issues', 'comicdb_issues.book_id', '=', 'comicdb_books.id')
					 ->join('comicdb_genrebook', 'comicdb_books.id', '=', 'comicdb_genrebook.book_id_FK')
					 ->join('comicdb_genre', 'comicdb_genre.id', '=', 'comicdb_genrebook.genre_id_FK')
					 ->where('genre_name', '=', $genre);	
	}

	public function scopeYears($query, $year) {
		return $query->join('comicdb_issues', 'comicdb_issues.book_id', '=', 'comicdb_books.id')
					 ->where(DB::raw('year(published_date)'), '=', $year);

	}

}
