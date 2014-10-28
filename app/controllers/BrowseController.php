<?php

class BrowseController extends BaseController {

	protected $layout = "layouts.master";

	public function getIndex()
	{
		$data['title'] = "The latest...";
		$data['comics'] = Comicbooks::latest()
							->select('book_id', 'issue_id', 'summary', 'book_name', 'cover_image')
							->distinct()->get();
		$latest_number = count($data['comics'])-1;
		for ($count=0; $count<$latest_number; $count++) {
			$summary = $data['comics'][$count]->summary;
			if(strlen($summary) > 300 ) { 
				$data['comics'][$count]->summary = substr($summary, 0, 300).'...'; 
			} 
		}
		$this->layout->content = View::make('browse', $data);
	}

	public function getBrowse($category){
		$data['title'] = strtoupper($category);
		switch(strtolower($category)):
			case 'series':
				$data['comics'] = Comicbooks::all();
				break;
			case 'authors':
				$data['comics'] = DB::table('comicdb_authors')->get();
				break;
			case 'artists':
				$data['comics'] = DB::table('comicdb_artists')->get();
				break;
			case 'characters':
				$data['comics'] = DB::table('comicdb_characters')->get();
				break;
			case 'publishers':
				$data['comics'] = DB::table('comicdb_publishers')->get();
				break;
			case 'genre':
				$data['comics'] = DB::table('comicdb_genre')->get();
				break;
			case 'year':
				$data['comics'] = DB::table('comicdb_issues')->select(DB::raw('year(published_date) as year'))->distinct()->get();
				break;
			default: 
				$data['title'] = "The latest...";
				$data['comics'] = Comicbooks::latest()
							->select('book_id', 'issue_id', 'summary', 'book_name', 'cover_image')
							->distinct()->get();
			   break;
		endswitch;
		
		$this->layout->content = View::make('browse', $data);
	}

	public function getSeries($book)
	{
		// THIS INVOKES A STATIC METHOD SERIES
		$data['book_title'] = $book;
		
		if (Comicbooks::series($book)->select('comicdb_books.id')->distinct()->first())
	    {
	    	$data['book_info'] = Comicbooks::series($book)->select('publisher_name','book_description')
												   ->distinct()->get();
		    $data['book_genre'] = Comicbooks::series($book)->select('genre_name')->distinct()->get();
		    $data['book_issues']= Comicbooks::series($book)->select('issue_id', 'cover_image', 'book_id')->distinct()->get();
			$data['book_characters'] = Comicbooks::bookcharacters($book)->select('character_name')->distinct()->get();
			$comic = Comicbooks::series($book)->select('comicdb_books.id')->first();
			$read = Userinfo::where('book_id_FK', $comic->id)
								->where('user_id_FK', Auth::id())
								->select('read_status', 'reading_status')->first();
			if ($read != '') {
				switch($read->read_status){
					case 0:
						$data['read_msg'] = 'MARK AS READ';
						$data['read_status'] = 1;
						break;
					case 1:
						$data['read_msg'] = 'MARK AS UNREAD';
						$data['read_status'] = 0;
						break;
				}

				switch($read->reading_status) {
					case 0:
						$data['reading_msg'] = 'ADD TO READLIST';
						$data['reading_status'] = 1;
						break;
					case 1:
						$data['reading_msg'] = 'REMOVE FROM READLIST';
						$data['reading_status'] = 0;
						break;
				}
			}
			else 
			{
				$data['read_msg'] = 'MARK AS READ';
				$data['read_status'] = 1;
				$data['reading_msg'] = 'ADD TO READLIST';
				$data['reading_status'] = 1;
			}


			
			$this->layout->content = View::make('series', $data);
		}
		else 
		{
			return Redirect::to('browse')->with('postMsg', 'Looks like that book does not exist! Please check out any other titles here.');
		}
	}

	public function getIssues($book, $issue_no){
		$data['book_title'] = $book;
		$data['book_issue'] = $issue_no;
		$data['book_info'] = Comicbooks::issues($book, $issue_no)->distinct()->get();
		$data['book_genre'] = Comicbooks::issuegenre($book, $issue_no)->distinct()->get();
		$this->layout->content = View::make('issues', $data);
	}

	public function getAuthors($author)
	{
		$data['author_name'] = $author;
		$data['author_cover'] = Comicbooks::authors($author)
	    										->select('cover_image')
												->orderBy('published_date', 'desc')
											   	->distinct()->get();
		$data['author_works'] = Comicbooks::authors($author)
									   ->select('book_name')
									   ->orderBy('published_date', 'desc')
									   ->distinct()->get();
	    $this->layout->content = View::make('author', $data);
	}

	public function getArtists($artist){
		$data['artist_name'] = $artist;
		$data['artist_cover'] = Comicbooks::artists($artist)
	    										->select('cover_image')
												->orderBy('published_date', 'desc')
											   	->distinct()->get();
		$data['artist_works'] = Comicbooks::artists($artist)
									   ->select('book_name')
									   ->orderBy('published_date', 'desc')
									   ->distinct()->get();
		$this->layout->content = View::make('artist', $data);
	}

	public function getPublishers($publisher){
		$data['publisher_name'] = $publisher;
		$data['publisher_cover'] = Comicbooks::publishers($publisher)
	    										->select('cover_image')
												->orderBy('published_date', 'desc')
											   	->distinct()
											   	->get();
		$data['publisher_works'] = Comicbooks::publishers($publisher)
								 		  ->select('book_name')
										  ->orderBy('published_date', 'desc')
										  ->distinct()
										  ->get();
		$this->layout->content = View::make('publisher', $data);
	}

	public function getGenres($genre){
		$data['genre_name'] = $genre;
		$data['genre_cover'] = Comicbooks::genres($genre)
									  ->select('cover_image')
									  ->orderBy('published_date', 'desc')
								   	  ->distinct()->get();
		$data['genre_works'] = Comicbooks::genres($genre)
								 		  ->select('book_name')
										  ->orderBy('published_date', 'desc')
										  ->distinct()->get();
		$this->layout->content = View::make('genre', $data);
	}

	public function getCharacters($character){
		$data['character_name'] = $character;
		$comics = new Comicbooks();
		$data['character_cover'] = $comics->characters($character)
									->select('cover_image')
									->orderBy('published_date', 'desc')
								   	->distinct()
								   	->get();
		$data['character_works'] = $comics->characters($character)
								 		  ->select('book_name')
										  ->orderBy('published_date', 'desc')
										  ->distinct()
										  ->get();
		$this->layout->content = View::make('character', $data);
	}

	public function getYears($year){
		$data['year_name'] = $year;
		$data['year_cover'] = Comicbooks::years($year)
									->select('cover_image')
									->orderBy('published_date', 'desc')
								   	->distinct()
								   	->get();
		$data['year_works'] = Comicbooks::years($year)
								 		  ->select('book_name')
										  ->orderBy('published_date', 'desc')
										  ->distinct()
										  ->get();
		$this->layout->content = View::make('year', $data);
	}
}
