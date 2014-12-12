<?php

//Comicissue model

class Comicissues extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'comicdb_issues';

	//Get the most recent four issues 
	public function scopeLatest($query){
		return $query->orderBy('published_date', 'desc')
					 ->take(4);
	}

	//Get all information of a issues of a title
	public function scopeIssues($query, $title, $id){
		return $query->join('comicdb_books','comicdb_books.id','=','comicdb_issues.book_id')
					 ->join('comicdb_artists', 'comicdb_artists.id','=','comicdb_issues.artist_id_FK')
					 ->join('comicdb_authors','comicdb_authors.id','=','comicdb_issues.author_id_FK')
					 ->where('comicdb_books.book_name', '=', $title)
					 ->where('comicdb_issues.issue_id', '=', $id);
	}

	//Get the number of issues in a series
	public function scopeIssuesCount($query, $title) {
		return $query->join('comicdb_books','comicdb_books.id','=','comicdb_issues.book_id')
					 ->join('comicdb_artists', 'comicdb_artists.id','=','comicdb_issues.artist_id_FK')
					 ->join('comicdb_authors','comicdb_authors.id','=','comicdb_issues.author_id_FK')
					 ->where('comicdb_books.book_name', '=', $title);
	}
	
}