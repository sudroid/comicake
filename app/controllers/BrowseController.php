<?php

class BrowseController extends BaseController {

	//Protected variables

	//Layout 
	protected $layout = "layouts.master";

	//Default error message
	protected $msg = '<div class="alert alert-warning alert-dismissible fade in" role="alert">
			      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
			      <strong>Oops!</strong> There\'s nothing here.
			    </div>';

    //Comic Vine API url
    protected $comicvine_url = "http://www.comicvine.com/api";

    //Comic Vine API Key 
    protected $api_key = "f195f882d737aee5bca1c43ac44a224b15307a1c";

    //Comicbookresources API url
    protected $cbr_url = "http://www.comicbookresources.com/feed.php?feed=news";

    /*
    * 	Get browse latest view
    *	Retrieves the last four issues uploaded to the database
    * 	Summary is cut down to 200 characters. 
    * 	This also gets the xml data from comicbookresource rss feed for the feed on the browse latest page
    */
	public function getIndex()
	{
		//Page Title 
		$data['title'] 	= "The latest...";

		//Get latest comicbooks' book id, issue id, summary, book name and cover image
		$data['comics'] = Comicbooks::latest()
							->select('book_id', 'issue_id', 'summary', 'book_name', 'cover_image')
							->distinct()->get();
		$latest_number 	= count($data['comics']);

		//Cut off Summary in the latest page to 200 characters
		for ($count=0; $count<$latest_number; $count++) {
			$summary = $data['comics'][$count]->summary;
			if(strlen($summary) > 200 ) { 
				$data['comics'][$count]->summary = substr($summary, 0, 200).'...'; 
			} 
		}

		//Get Comicbookresources xml 
		if ($response_xml_data = file_get_contents($this->cbr_url))
		{
			$xml_data = simplexml_load_string($response_xml_data);
			foreach($xml_data->channel->item as $item) {
				$data['news_item'][] = $item;
			}
		}
		$this->layout->content = View::make('browse', $data);
	}

	/*
	*	Get browse category page
	* 	This will be according to the route request
	* 	If it doesn't match any of the side panel options, then redirect to the Error page
	*/
	public function getBrowse($category){

		//Get browse category
		$category_filtered 	= strtoupper(trim($category));

		//Page Title 
		$data['title'] 		= $category_filtered;

		//Switch to get appropriate data, redirect to error if options aren't listed
		switch($category_filtered):
			case 'SERIES':
				$data['comics'] = Comicbooks::orderBy('book_name', 'asc')->get();
				break;
			case 'AUTHORS':
				$data['comics'] = Authors::select('author_name')->orderBy('author_name', 'asc')->distinct()->get();
				break;
			case 'ARTISTS':
				$data['comics'] = Artists::select('artist_name')->orderBy('artist_name', 'asc')->distinct()->get();
				break;
			case 'CHARACTERS':
				$data['comics'] = Characters::select('character_name')->orderBy('character_name', 'asc')->distinct()->get();
				break;
			case 'PUBLISHERS':
				$data['comics'] = Publishers::select('publisher_name')->orderBy('publisher_name', 'asc')->distinct()->get();
				break;
			case 'GENRES':
				$data['comics'] = Genres::orderBy('genre_name', 'asc')->get();
				break;
			case 'YEARS':
			//This needed to be a raw query because of the date 
				$data['comics'] = Comicissues::select(DB::raw('year(published_date) as year'))->orderBy('published_date', 'asc')->distinct()->get();
				break;
			default: 
				return Redirect::to('error');
			   break;
		endswitch;
		$this->layout->content = View::make('browse', $data);
	}

	/*
	*	Get a specific comicbook series information
	* 	This includes the read list and the to-read list options
	*/
	public function getSeries($book)
	{
		//Page Title 
		$data['book_title'] = $book;

		//Get the first result of book series query 
		$data['book'] 		= Comicbooks::series($book)->select('comicdb_books.id')->distinct()->first();
		
		//If it's not null...
		if ($data['book'])
	    {
	    	//Get book information
	    	$data['book_info'] 		 = Comicbooks::series($book)->select('publisher_name','book_description')->distinct()->get();
		    $data['book_genre'] 	 = Comicbooks::series($book)->select('genre_name')->distinct()->get();
		    $data['book_issues']	 = Comicbooks::series($book)->select('issue_id', 'cover_image', 'book_id')->distinct()->get();
			$data['book_characters'] = Comicbooks::bookcharacters($book)->select('character_name')->distinct()->get();
			$comic 					 = Comicbooks::series($book)->select('comicdb_books.id')->first();
			$read 					 = Userinfo::where('book_id_FK', $comic->id)->where('user_id_FK', Auth::id())->select('read_status', 'reading_status')->first();
			//If read variable isn't empty
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
			else //else set to default values
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
			//Redirect to the error page if the book series it doesn't exist
			return Redirect::to('error');
		}
	}

	/*
	* 	Get a specific comicbook series' issue information 
	*/
	public function getIssues($book, $issue_no){
		$data['book_title'] = $book;
		$data['book_issue'] = $issue_no;

		//Get issue information
		$data['book_info'] 	= Comicbooks::issues($book, $issue_no)->distinct()->get();
		$data['book_genre'] = Comicbooks::issuegenre($book, $issue_no)->distinct()->get();

		//Check to see if issue exist. If it doesn't Redirect to error page
		$data['has_issue'] 	= (count($data['book_info'])) ? true : false;
		if (!$data['has_issue']) {
			return Redirect::to('error');
		}
		$this->layout->content = View::make('issues', $data);
	}

	/*
	* 	Get a specific Author information
	* 	If the author doesn't have any information in the database, then 
	* 	redirect user to the wikipedia page of them.
	*/
	public function getAuthors($author)
	{
		//Get Author information
		$data['author_name']  = $author;
		$data['author_cover'] = Comicbooks::authors($author)
	    										->select('cover_image')
												->orderBy('published_date', 'asc')
											   	->distinct()->get();
		$data['author_works'] = Comicbooks::authors($author)
									   ->select('book_name')
									   ->orderBy('published_date', 'asc')
									   ->distinct()->get();

	   //Check to see if author exist in database. If it doesn't Redirect to a wiki page
		$data['has_author']   = (count($data['author_works'])) ? true : false;
		if (!$data['has_author']) {
			return Redirect::away("http://en.wikipedia.org/wiki/".ucwords($author));
		}
	    $this->layout->content = View::make('author', $data);
	}

	/*
	* 	Get a specific Artist information
	* 	If the artist doesn't have any information in the database, then 
	* 	redirect user to the wikipedia page of them.
	*/
	public function getArtists($artist){
		$data['artist_name']  = $artist;
		//Get Artist information
		$data['artist_cover'] = Comicbooks::artists($artist)
	    										->select('cover_image')
												->orderBy('published_date', 'asc')
											   	->distinct()->get();
		$data['artist_works'] = Comicbooks::artists($artist)
									   ->select('book_name')
									   ->orderBy('published_date', 'asc')
									   ->distinct()->get();

	   	//Check to see if artist exist in database. If it doesn't Redirect to a wiki page
	    $data['has_artist']   = (count($data['artist_works'])) ? true : false;
		if (!$data['has_artist']) {
			return Redirect::away("http://en.wikipedia.org/wiki/".ucwords($artist));
		}
		$this->layout->content = View::make('artist', $data);
	}

	/*
	* 	Get a specific Publisher information
	* 	If the publisher doesn't have any information in the database, then 
	* 	redirect user to the wikipedia page of them.
	*/
	public function getPublishers($publisher){
		$data['publisher_name']  = $publisher;
		//Get Publisher information
		$data['publisher_cover'] = Comicbooks::publishers($publisher)
	    										->select('cover_image')
												->orderBy('published_date', 'asc')
											   	->distinct()
											   	->get();
		$data['publisher_works'] = Comicbooks::publishers($publisher)
								 		  ->select('book_name')
										  ->orderBy('published_date', 'asc')
										  ->distinct()
										  ->get();

	    //Check to see if publisher exist in database. If it doesn't Redirect to a wiki page
		$data['has_publisher'] 	 = (count($data['publisher_works'])) ? true : false;
		if (!$data['has_publisher']) {
			return Redirect::away("http://en.wikipedia.org/wiki/".ucwords($publisher));
		}
		$this->layout->content = View::make('publisher', $data);
	}

	/*
	* 	Get a specific Genre information
	* 	If the author doesn't have any information in the database, then 
	* 	redirect user to the wikipedia page of them.
	*/
	public function getGenres($genre){
		$data['genre_name'] = $genre;
		//Get Genre list from database
		$genre_list 		= Genres::lists('genre_name');
		//Check and see if Genre is in Genre list. If it doesn't, redirect to error page
		if (!in_array($genre, $genre_list)) {
			return Redirect::to('error');
		}
		else {		
			//Get Genre information
			$data['genre_cover'] = Comicbooks::genres($genre)
									  ->select('cover_image')
									  ->orderBy('comicdb_books.created_at', 'desc')
								   	  ->distinct()->get();
			$data['genre_works'] = Comicbooks::genres($genre)
									 		  ->select('book_name')
											  ->orderBy('comicdb_books.created_at', 'desc')
											  ->distinct()->get();
		}
		$this->layout->content = View::make('genre', $data);
	}

	/*
	* 	Get a specific Character information
	* 	This will use the ComicVine API to get more information 
	* 	about the character as well as what is in the database.
	*   If the character doesn't have any information in the database, 
	*	then redirect user to the wikipedia page of them.
	*/
	public function getCharacters($character){
		$data['character_name']  = $character;
		//Get character information from Comic Vine API
		$xml_url = $this->comicvine_url."/characters/?api_key=".$this->api_key."&filter=name:".strtolower($character);
		if ($response_xml_data = file_get_contents($xml_url)) {
			$xml_data = simplexml_load_string($response_xml_data);
			$character_data = $xml_data->results->character; 
			//Check if character has data in Comic Vine, else put in empty values
			if ( count($character_data) > 0 ) {
				$data['detail_url'] = (string)$character_data->site_detail_url;
				$aliases = $character_data->aliases;
				$data['aliases'] = explode("\n", $aliases);
				$data['appearances_count'] = $character_data->count_of_issue_appearances;
				$data['image'] = (string)$character_data->image->medium_url;
				$data['description'] = (string)$character_data->deck;
				$data['publisher'] = strtolower((string)$character_data->publisher->name);
			}
			else {
				//
				$data['detail_url'] = "";
				$data['aliases'] = "";
				$data['appearances_count'] =  "";
				$data['image'] =  "";
				$data['description'] =  "";
				$data['publisher'] = "";
			}
		}

		//Get character's comicbook info
		$data['character_cover'] = Comicbooks::characters($character)
									->select('cover_image')
									->orderBy('published_date', 'asc')
								   	->distinct()
								   	->get();
		$data['character_works'] = Comicbooks::characters($character)
								 		  ->select('book_name')
										  ->orderBy('published_date', 'asc')
										  ->distinct()
										  ->get();

		//Check if character has appearances in the comics that are in the database. 
	    //If not redirect character wiki page
		$data['has_character'] 	 = (count($data['character_works'])) ? true : false;
		if (!$data['has_character']) {
			return Redirect::away("http://en.wikipedia.org/wiki/".ucwords($character));
		}
		$this->layout->content = View::make('character', $data);
	}

	/*
	* 	Get the issues that were published in a specific year 
	* 	If the year doesn't have any information in the database, 
	*	then redirect user to the wikipedia page of them.
	*/
	public function getYears($year){
		$data['year_name'] 	= $year;

		//Get comics published in a specific year
		$data['year_cover'] = Comicbooks::years($year)
									->select('cover_image')
									->orderBy('published_date', 'asc')
								   	->distinct()
								   	->get();
		$data['year_works'] = Comicbooks::years($year)
								 		  ->select('book_name')
										  ->orderBy('published_date', 'asc')
										  ->distinct()
										  ->get();
		$data['has_year'] 	= (count($data['year_works'])) ? true : false;
		//If there are no series published in the year (because of URL tempering), return with error message
		if (!$data['has_year']) {
			return Redirect::to('browse/year')->with('postMsg', $this->msg);
		}
		$this->layout->content = View::make('year', $data);
	}
}
