<?php

class BrowsingController extends BaseController {

	protected $layout = "layouts.master";

	public function getSeries($book)
	{
		// THIS INVOKES A STATIC METHOD SERIES
		$data['book_title'] = $book;
		$data['book_info'] = Comicdb::series($book)->select('comicdb_issues.issue_id','publisher_name','book_description', 'genre_name', 'cover_image')
												   ->distinct()->get();
		$this->layout->content = View::make('series', $data);
	}

	public function getIssues($book, $issue_no){
		$comics = new Comicdb();
		$data['book_title'] = $book;
		$data['book_info'] = Comicdb::issues($book, $issue_no)->distinct()->get();
		$data['book_genre'] = Comicdb::issuegenre($book, $issue_no)->distinct()->get();
		$data['book_characters'] = Comicdb::bookcharacters($book)->select('character_name')->distinct()->get();
		$this->layout->content = View::make('issues', $data);
	}

	public function getAuthors($author)
	{
		//THIS INVOKES NON-STATIC METHOD
		$comics = new Comicdb();
		$data['author_name'] = $author;
		$data['author_cover'] = $comics->authors($author)
	    										->select('cover_image')
												->orderBy('published_date', 'desc')
											   	->distinct()
											   	->get();
		$data['author_works'] = $comics->authors($author)
									   ->select('book_name', 'author_description')
									   ->orderBy('published_date', 'desc')
									   ->distinct()
									   ->get();
	    
		$this->layout->content = View::make('author', $data);
	}

	public function getArtists($artist){
		$data['artist_name'] = $artist;
		$comics = new Comicdb();
		$data['artist_cover'] = $comics->artists($artist)
	    										->select('cover_image')
												->orderBy('published_date', 'desc')
											   	->distinct()
											   	->get();
		$data['artist_works'] = $comics->artists($artist)
									   ->select('book_name','artist_description')
									   ->orderBy('published_date', 'desc')
									   ->distinct()
									   ->get();
		$this->layout->content = View::make('artist', $data);
	}

	public function getPublishers($publisher){
		$data['publisher_name'] = $publisher;
		$comics = new Comicdb();
		$data['publisher_cover'] = $comics->publishers($publisher)
	    										->select('cover_image')
												->orderBy('published_date', 'desc')
											   	->distinct()
											   	->get();
		$data['publisher_works'] = $comics->publishers($publisher)
								 		  ->select('book_name')
										  ->orderBy('published_date', 'desc')
										  ->distinct()
										  ->get();
		$this->layout->content = View::make('publisher', $data);
	}

	public function getGenres($genre){
		$data['genre_name'] = $genre;
		$comics = new Comicdb();
		$data['genre_cover'] = $comics->genres($genre)
									  ->select('cover_image')
									  ->orderBy('published_date', 'desc')
								   	  ->distinct()->get();
		$data['genre_works'] = $comics->genres($genre)
								 		  ->select('book_name')
										  ->orderBy('published_date', 'desc')
										  ->distinct()->get();
		$this->layout->content = View::make('genre', $data);
	}

	public function getCharacters($character){
		$data['character_name'] = $character;
		$comics = new Comicdb();
		$data['character_cover'] = $comics->characters($character)
									->select('cover_image')
									->orderBy('published_date', 'desc')
								   	->distinct()
								   	->get();
		$data['character_works'] = $comics->characters($character)
								 		  ->select('book_name', 'character_description')
										  ->orderBy('published_date', 'desc')
										  ->distinct()
										  ->get();
		$this->layout->content = View::make('character', $data);
	}

	public function getYears($year){
		$data['year_name'] = $year;
		$comics = new Comicdb();
		$data['year_cover'] = $comics->years($year)
									->select('cover_image')
									->orderBy('published_date', 'desc')
								   	->distinct()
								   	->get();
		$data['year_works'] = $comics->years($year)
								 		  ->select('book_name')
										  ->orderBy('published_date', 'desc')
										  ->distinct()
										  ->get();
		$this->layout->content = View::make('year', $data);
	}
}
