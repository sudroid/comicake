<?php

//NOTE: http://fideloper.com/laravel-raw-queries 

class BrowseController extends BaseController {

	protected $layout = "layouts.master";

	protected $msg = '<div class="alert alert-warning alert-dismissible fade in" role="alert">
			      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
			      <strong>Oops!</strong> There\'s nothing here.
			    </div>';

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
		$category_filtered = strtoupper(trim($category));
		$data['title'] = $category_filtered;
		switch($category_filtered):
			case 'SERIES':
				$data['comics'] = Comicbooks::get();
				break;
			case 'AUTHORS':
				$data['comics'] = Authors::get();
				break;
			case 'ARTISTS':
				$data['comics'] = Artists::get();
				break;
			case 'CHARACTERS':
				$data['comics'] = Characters::get();
				break;
			case 'PUBLISHERS':
				$data['comics'] = Publishers::get();
				break;
			case 'GENRES':
				$data['comics'] = Genres::get();
				break;
			case 'YEARS':
				$data['comics'] = Comicissues::select(DB::raw('year(published_date) as year'))->distinct()->get();
				break;
			default: 
				return Redirect::to('error');
			   break;
		endswitch;
		$this->layout->content = View::make('browse', $data);
	}

	public function getSeries($book)
	{
		// THIS INVOKES A STATIC METHOD SERIES
		$data['book_title'] = $book;
		$data['book'] = Comicbooks::series($book)->select('comicdb_books.id')->distinct()->first();
		if ($data['book'])
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
			return Redirect::to('error');
		}
	}

	public function getIssues($book, $issue_no){
		$data['book_title'] = $book;
		$data['book_issue'] = $issue_no;
		$data['book_info'] = Comicbooks::issues($book, $issue_no)->distinct()->get();
		$data['book_genre'] = Comicbooks::issuegenre($book, $issue_no)->distinct()->get();
		//var_dump($data['book_info']);
		$data['has_issue'] = (count($data['book_info'])) ? true : false;
		if (!$data['has_issue']) {
			return Redirect::to('error');
		}
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

		$data['has_author'] = (count($data['author_works'])) ? true : false;
		if (!$data['has_author']) {
			return Redirect::to('error');
		}
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
	    $data['has_artist'] = (count($data['artist_works'])) ? true : false;
		if (!$data['has_artist']) {
			return Redirect::to('error');
		}
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
		$data['has_publisher'] = (count($data['publisher_works'])) ? true : false;
		if (!$data['has_publisher']) {
			return Redirect::to('error');
		}
		$this->layout->content = View::make('publisher', $data);
	}

	public function getGenres($genre){
		$data['genre_name'] = $genre;
		$genre_list = Genres::lists('genre_name');
		if (!in_array($genre, $genre_list)) {
			return Redirect::to('error');
		}
		else {		
			$data['genre_cover'] = Comicbooks::genres($genre)
									  ->select('cover_image')
									  ->orderBy('published_date', 'desc')
								   	  ->distinct()->get();
			$data['genre_works'] = Comicbooks::genres($genre)
									 		  ->select('book_name')
											  ->orderBy('published_date', 'desc')
											  ->distinct()->get();
		    $data['has_genre'] = (count($data['genre_works'])) ? true : false;

		    if (!$data['has_genre']) {
				return Redirect::to('browse/genres')->with('postMsg', $this->msg);
			}
		}
		$this->layout->content = View::make('genre', $data);
	}

	public function getCharacters($character){
		$data['character_name'] = $character;
		$data['character_cover'] = Comicbooks::characters($character)
									->select('cover_image')
									->orderBy('published_date', 'desc')
								   	->distinct()
								   	->get();
		$data['character_works'] = Comicbooks::characters($character)
								 		  ->select('book_name')
										  ->orderBy('published_date', 'desc')
										  ->distinct()
										  ->get();
		$data['has_character'] = (count($data['character_works'])) ? true : false;
		if (!$data['has_character']) {
			return Redirect::to('error');
		}
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
		$data['has_year'] = (count($data['year_works'])) ? true : false;
		if (!$data['has_year']) {
			return Redirect::to('browse/year')->with('postMsg', $this->msg);
		}
		$this->layout->content = View::make('year', $data);
	}
}
