<?php

class ContentController extends BaseController {
	protected $layout = "layouts.master";

	public function __construct() {

		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->beforeFilter('auth');
		$this->beforeFilter('auth', array('only'=>array('store', 'edit', 'update')));
		$this->beforeFilter('auth.admin', array('only'=>array('destroy')));
	}

	/**
	 * Display a listing of the resource.
	 * GET /content
	 *
	 * @return Response
	 */
	public function index()
	{
		$data['genres'] = Genres::orderby('genre_name', 'asc')->lists('genre_name', 'id');
		$this->layout->content = View::make('addseries', $data);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /content/store
	 *
	 * @return Response
	 */
	public function store()
	{
		$inputs = Input::only('book_name', 'publisher_name', 'author_name', 'artist_name');
		Input::merge(array_map('trim', $inputs));
		$this->createSession();
		$rules = array(
		    'book_name' => 'required|unique:comicdb_books',
		    'publisher_name' => 'required|min:1',
		    'book_description' => 'max:2000',
		    'genres' => 'min:1', 
		    'author_name' => 'required|min:1',
		    'artist_name' => 'required|min:1',
		    'published_date' => 'required|date_format:yy-m-d',
		    'cover_image' => 'required|image',
		    'characters' => 'min:1'
 		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->passes()) {
			$comic = new Comicbooks;
			$publishers = new Publishers;
			$publisher = strtolower(Input::get('publisher_name'));
			$author = strtolower(Input::get('author_name'));		
			$artist = strtolower(Input::get('artist_name'));
			$publisherExists = $publishers->where('publisher_name', $publisher)->select('id')->first();
			$authorExists = Authors::where('author_name', $author)->select('id')->first();
			$artistExists = Artists::where('artist_name', $artist)->select('id')->first();
			
			if (isset($publisherExists->id))
			{
				$publisher_id = $publisherExists->id;
			}	
			else {
				$publisher_id = $publishers->insertGetId(array('publisher_name'=> $publisher));
			}

			if(isset($authorExists))
			{
				$author_id = $authorExists->id;
				
			}
			else 
			{
				$author_id = Authors::insertGetId(array('author_name'=>$author));
				
			}

			if(isset($artistExists))
			{
				$artist_id = $artistExists->id;
				
			}
			else 
			{
				$artist_id = Artists::insertGetId(array('artist_name'=>$artist));
				
			}

			//Add book series information to comicdb_books
			$comic->book_name = strtolower(Input::get('book_name'));
			$comic->book_description = Input::get('book_description');
			$comic->publisher_id_FK = $publisher_id;
			$comic->save();

			//Add genre and book ids in the comicdb_genrebook
			foreach (Input::get('genres') as $key => $genre){
				DB::table('comicdb_genrebook')->insert(array('book_id_FK'=>$comic->id, 'genre_id_FK'=>$genre));
			}	
			if (Input::hasFile('cover_image'))
			{
				$fileName = strtolower(Input::get('book_name')).'01_Cov_'.Str::random(10).'.'.Input::file('cover_image')->getClientOriginalExtension();
				$cover_image = Input::file('cover_image')->move('public/img/comic_covers/', $fileName);
			}

			//Add issue character information into the comicdb_character table and keys into the comicdb_characterbook table
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
			
			return Redirect::to('browse')->with('postMsg', 'Thanks for submiting!');
		} else {
			return Redirect::to('content/series')->with('postMsg', 'Whoops! Looks like you got some errors.')->withErrors($validator);
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /content/{title}/edit
	 *
	 * @param  string  $title
	 * @return Response
	 */
	public function edit($title)
	{
		$comic = new Comicbooks();
		$data['book_title'] = $title;
		$book_id = $comic->series($title)->select('comicdb_books.id as id')->first();
		$data['id'] =$book_id ;
		if ($book_id)
		{
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
	 * Update the specified resource in storage.
	 * PUT /content/{title}
	 *
	 * @param  int  $title
	 * @return Response
	 */
	public function update($title)
	{
		//Input::merge(array_map('trim', Input::all()));
		$rules = array(
		    'book_name' => 'required|min:1',
		    'publisher_name' => 'required|min:1',
		    'book_description' => 'max:2000',
		    'genres' => 'min:1',
		    'characters' => 'min:1' 
 		);

 		$validator = Validator::make(Input::all(), $rules);
 		$comic = new Comicbooks;
 		$book_id = $comic->series($title)->select('comicdb_books.id')->first();
 		// $data['book_id'] = $book_id->id;
 		// $this->layout->content = View::make('test', $data);
		if (isset($book_id->id))
		{
			if ($validator->passes()) {
				$publishers = new Publishers;
				$book_name = strtolower(Input::get('book_name'));
				$publisher = strtolower(Input::get('publisher_name'));

				//If publisher already exists, get the id of that publisher from the comicdb_publishers table
				$publisherExists = $publishers->where('publisher_name', $publisher)->select('id')->first();
				if (isset($publisherExists->id))
				{
					$publisher_id = $publisherExists->id;

				}	
				else {
					$publisher_id = $publishers->insertGetId(array('publisher_name'=> $publisher));
				}
				$update_comic = $comic->findOrFail($book_id->id);
				$update_comic->book_name = $book_name;
				$update_comic->book_description = Input::get('book_description');
				$update_comic->publisher_id_FK = $publisher_id;
				$update_comic->save();

				//Delete then reinsert all the values because that way is easier.
				DB::table('comicdb_genrebook')->where('book_id_FK', $update_comic->id)->delete();
				foreach (Input::get('genres') as $key => $genre){
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
		}
		else 
		{
			return Redirect::to('content.series.edit')->with('postMsg', 'That book does not exist!');
		}
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /content/{title}
	 *
	 * @param  string $title
	 * @return Response
	 */
	public function destroy($title)
	{
		$comic = new Comicbooks;
		$book_id = $comic->series($title)->select('comicdb_books.id')->distinct()->get();
		$delete_comic = $comic->findOrFail($book_id[0]->id);
		if ($delete_comic)
		{
			$delete_comic->delete($book_id);
		return Redirect::to('browse')->with('postMsg', 'The book has been deleted.');
		} else {
			return Redirect::to(URL::previous())->with('postMsg', 'Whoops! Looks like you got some errors.');
		}
	}

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

	public function destorySession(){
		Session::forget('book_name');
		Session::forget('publisher_name');
		Session::forget('book_description');
		Session::forget('author_name');
		Session::forget('artist_name');
		Session::forget('issue_summary');
	}

}