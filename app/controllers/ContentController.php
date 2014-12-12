<?php

class ContentController extends BaseController {

	//Protected variable - master layout
	protected $layout = "layouts.master";

	/*
	*	Constructor sets beforeFilters
	*/
	public function __construct() {
		//See filters.php
		//Laravel contains a built in protectin for cross-site request forgery on POST. 
		$this->beforeFilter('csrf', array('on'=>'post'));
		//Auth filter 
		// Only users can accesss these methods (creating a new series, editting it and updating it)
		$this->beforeFilter('auth', array('only'=>array('store', 'edit', 'update')));
		//Admin filter
		// Only admin can access destroy (deleting the series)
		$this->beforeFilter('auth.admin', array('only'=>array('destroy')));
	}

	/**
	 * Show the form for adding a new comicbook series.
	 * GET /content
	 *
	 */
	public function index()
	{
		//Destroy session data
		$this->destorySession();
		//Get genre list
		$data['genres'] = Genres::orderby('genre_name', 'asc')->lists('genre_name', 'id');
		$this->layout->content = View::make('addseries', $data);
	}

	/**
	 * Adding a comicbook series into the database
	 * GET /content/store
	 *
	 * @return Response
	 */
	public function store()
	{
		//Get string inputs
		$inputs = Input::only('book_name', 'publisher_name', 'author_name', 'artist_name');
		//Trim string inputs
		Input::merge(array_map('trim', $inputs));
		//Create session 
		$this->createSession();
		//Set validation rules
		$rules = array(
		    'book_name' => 'required|unique:comicdb_books',
		    'publisher_name' => 'required|min:1',
		    'book_description' => 'max:2000',
		    'genres' => 'min:1', 
		    'author_name' => 'required|min:1',
		    'artist_name' => 'required|min:1',
		    'published_date' => 'required|date_format:yy-m-d',
		    'cover_image' => 'required|image',
		    'characters' => 'min:1',
		    'issue_summary' => 'max:2000'
 		);

		//Laravel Validation class and make method takes the inputs in the first argument 
		//then the rules on the data in the second
		$validator = Validator::make(Input::all(), $rules);
		
		//Validator instance use the pass method to continue
		if ($validator->passes()) {
			//Instance of Comicbook model
			$comic = new Comicbooks;
			//Instance of Publisher model
			$publishers = new Publishers;
			//Setting variables
			$publisher = strtolower(Input::get('publisher_name'));
			$author = strtolower(Input::get('author_name'));		
			$artist = strtolower(Input::get('artist_name'));
			$publisherExists = $publishers->where('publisher_name', $publisher)->select('id')->first();
			$authorExists = Authors::where('author_name', $author)->select('id')->first();
			$artistExists = Artists::where('artist_name', $artist)->select('id')->first();
			
			//Check if publisher already exist in the database
			if (isset($publisherExists->id)){
				//if it does get the id
				$publisher_id = $publisherExists->id;
			} else {
				//else create it in the Publisher table using the instance of publisher model
				$publisher_id = $publishers->insertGetId(array('publisher_name'=> $publisher));
			}

			//Check if author already exist in the database
			if(isset($authorExists)){
				//if they do get the id
				$author_id = $authorExists->id;
			} else {
				//else create it in the Authors table using the instance of author model
				$author_id = Authors::insertGetId(array('author_name'=>$author));
			}

			//Check if artist already exist in the database
			if(isset($artistExists)){
				//if they do get the id
				$artist_id = $artistExists->id;
			} else {
				//else create it in the Artists table using the instance of artist model
				$artist_id = Artists::insertGetId(array('artist_name'=>$artist));
			}

			//Add book series information to comicdb_books
			$comic->book_name = strtolower(Input::get('book_name'));
			$comic->book_description = Input::get('book_description');
			$comic->publisher_id_FK = $publisher_id;
			$comic->save();

			//Add genre and book ids in the comicdb_genrebook using Query Builder
			foreach (Input::get('genres') as $key => $genre){
				DB::table('comicdb_genrebook')->insert(array('book_id_FK'=>$comic->id, 'genre_id_FK'=>$genre));
			}	
			//Add cover image to local file and set location string into database
			if (Input::hasFile('cover_image'))
			{
				$fileName = strtolower(Input::get('book_name')).'01_Cov_'.Str::random(10).'.'.Input::file('cover_image')->getClientOriginalExtension();
				$cover_image = Input::file('cover_image')->move('public/img/comic_covers/', $fileName);
			}

			//Add issue character information into the comicdb_character table and keys into the comicdb_characterbook table using Query Builder
			foreach (Input::get('characters') as $key => $character){
				$character_id = Characters::insertGetId(array('character_name'=>$character));
				DB::table('comicdb_characterbook')->insert(array('book_id_FK'=>$comic->id, 'character_id_FK'=>$character_id));
			}	

			//Add issues information to comicdb_issues
			Comicissues::insert(
				array(
						'book_id'=>$comic->id, 
						'issue_id'=>1, 
						'artist_id_FK'=>$artist_id,
						'author_id_FK'=>$author_id,
						'summary'=>Input::get('issue_summary'),
						'published_date' => Input::get('published_date'),
						'cover_image' => 'img/comic_covers/'.$fileName,
						'created_at' => date('Y-m-d H:i:s', time())
					)
			);
			$this->destorySession;
			return Redirect::to('browse')->with('postMsg', 'Thanks for submiting!');
		} else {
			return Redirect::to('content/series')->with('postMsg', 'Whoops! Looks like you got some errors.')->withErrors($validator);
		}
	}

	/**
	 * Show the form for editing a comicbook series
	 * GET /content/{title}/edit
	 *
	 * @param  string  $title
	 * @return Response
	 */
	public function edit($title)
	{
		//Instance of Comicbook model
		$comic = new Comicbooks();
		//Set variables
		$data['book_title'] = $title;
		$book_id 			= $comic->series($title)->select('comicdb_books.id as id')->first();
		$data['id'] 		= $book_id;
		//If book exists, get the issue information and fill the form with it
		if (!is_null($book_id)) {
			$data['book_info'] = $comic->series($title)->select('comicdb_books.id as id', 'book_name', 'publisher_name', 'book_description')->distinct()->get();
			$data['selected_genres'] = $comic->series($title)->select('comicdb_genre.id', 'genre_name')->distinct()->get();
			$data['book_characters'] = $comic->bookcharacters($title)->select('character_name')->distinct()->get();
			$data['book_genres'] = Genres::lists('genre_name', 'id');
			$this->layout->content = View::make('editseries', $data);
		}
		else 
		{
			return Redirect::to('editseries')->with('postMsg', 'These are not the comics you are looking for.')->withErrors($validator)->withInput();
		}
	}

	/**
	 * Update a comicbook series
	 * PUT /content/{title}
	 *
	 * @param  int  $title
	 * @return Response
	 */
	public function update($title)
	{
		//Set rules
		$rules = array(
		    'book_name' => 'required|min:1',
		    'publisher_name' => 'required|min:1',
		    'book_description' => 'max:2000',
		    'genres' => 'min:1',
		    'characters' => 'min:1' 
 		);
		//Validate
 		$validator = Validator::make(Input::all(), $rules);
 		//Instance of Comicbook model
 		$comic = new Comicbooks;
 		$book_id = $comic->series($title)->select('comicdb_books.id')->first();
 		//If the comicbook series exists
		if (!is_null($book_id)) {
			//If validation passes
			if ($validator->passes()) {
				//Instance of Publisher model
				$publishers = new Publishers;
				//Set variables
				$book_name = strtolower(Input::get('book_name'));
				$publisher = strtolower(Input::get('publisher_name'));

				//If publisher already exists, get the id of that publisher from the comicdb_publishers table
				$publisherExists = $publishers->where('publisher_name', $publisher)->select('id')->first();
				if (isset($publisherExists->id)){
					$publisher_id = $publisherExists->id;
				} else {
					$publisher_id = $publishers->insertGetId(array('publisher_name'=> $publisher));
				}

				//Update comic series
				$update_comic = $comic->findOrFail($book_id->id);
				$update_comic->book_name = $book_name;
				$update_comic->book_description = Input::get('book_description');
				$update_comic->publisher_id_FK = $publisher_id;
				$update_comic->save();

				//Delete then reinsert all the values because that way is easier.
				DB::table('comicdb_genrebook')->where('book_id_FK', $update_comic->id)->delete();
				foreach (Input::get('genres') as $key => $genre) {
					DB::table('comicdb_genrebook')->insert(array('book_id_FK'=>$update_comic->id, 'genre_id_FK'=>$genre));
				}

				//Add issue character information into the comicdb_character table and keys into the comicdb_characterbook table
				DB::table('comicdb_characterbook')->where('book_id_FK', $update_comic->id)->delete();
				foreach (Input::get('characters') as $key => $character){
					$character_id = Characters::insertGetId(array('character_name'=>$character));
					DB::table('comicdb_characterbook')->insert(array('book_id_FK'=>$update_comic->id, 'character_id_FK'=>$character_id));
				}	

				return Redirect::to('browse')->with('postMsg', 'The book has been updated!');
			} else {
				return Redirect::to('content.series.edit')->with('postMsg', 'Whoops! Looks like you got some errors.')->withErrors($validator)->withInput();
			}
		} else  {
			return Redirect::to('content.series.edit')->with('postMsg', 'That book does not exist!');
		}
	}

	/**
	 * Remove a comicbook series from the database
	 * DELETE /content/{title}
	 *
	 * @param  string $title
	 * @return Response
	 */
	public function destroy($title)
	{
		//Instance of Comicbooks model
		$comic = new Comicbooks;
		$book_id = $comic->series($title)->select('comicdb_books.id')->distinct()->get();
		$delete_comic = $comic->findOrFail($book_id[0]->id);
		//If the comicbook series exists
		if ($delete_comic){
			//Delete any instance of it in the Userinfo table (tracks unread/to read list)
			Userinfo::where('book_id_FK', '=', $book_id[0]->id)->delete();
			//Delete any instance of it in the comicbook issues table
			Comicissues::where('book_id', '=', $book_id[0]->id)->delete();
			//Delete the comicbook series in the comicbook books table
			$delete_comic->delete($book_id[0]->id);
			return Redirect::to('browse')->with('postMsg', 'The book has been deleted.');
		} else {
			return Redirect::to(URL::previous())->with('postMsg', 'Whoops! Looks like you got some errors.');
		}
	}

	/*
	*	Create session data
	*/
	public function createSession() {
		Session::put(array(
 				'book_name'	 => Input::get('book_name'),
				'publisher_name' 	 => Input::get('publisher_name'),
				'book_description'  	 => Input::get('book_description'),
				'author_name' => Input::get('author_name'),
				'artist_name'  	 => Input::get('artist_name'),
				'issue_summary'  => Input::get('issue_summary')
		));
	}

	/*
	*	Destroy session data
	*/
	public function destorySession(){
		Session::forget('book_name');
		Session::forget('publisher_name');
		Session::forget('book_description');
		Session::forget('author_name');
		Session::forget('artist_name');
		Session::forget('issue_summary');
	}

}