<?php

class IssueController extends BaseController {

	//Protected variable - master layout
	protected $layout = "layouts.master";

	/*
	*	Constructor sets beforeFilters
	*/
	public function __construct() {
		//See filters.php
		//Laravel contains a built in protectin for cross-site request forgery on POST. 
		//See filters.php
		$this->beforeFilter('csrf', array('on'=>'post'));
		//Auth filter 
		// Only users can accesss these methods (creating a new issue, editting it and updating it)
		$this->beforeFilter('auth', array('only'=>array('create', 'store', 'update')));
		//Admin filter
		// Only admin can access destroy (deleting the issue)
		$this->beforeFilter('auth.admin', array('only'=>array('destroy')));

	}

	/**
	 * Show the form for adding a new issue to the database
	 *
	 * @return Response
	 */
	public function create()
	{
		//Get book series title from session variable
		$title = Session::get('book_title');
		//Check if book series exists, then draw data for it to add issue
		$book_id = Comicbooks::series($title)->select('comicdb_books.id')->first();
		if ($book_id->exists) {
			$data['book_title'] 	= '<em>'.strtoupper($title).'</em>';
			$data['book_id'] 		= Comicbooks::series($title)->select('comicdb_books.id')->first();
			$this->layout->content 	= View::make('addissues', $data);
		} else {
			return Redirect::to('browse')->with('postMsg', 'Looks like that book does not exist! Please check out any other titles here.');
		}
	}


	/**
	 * Save the issue in to the database.
	 *
	 * @return Response
	 */
	public function store()
	{
		//Trim all inputs 
		Input::merge(array_map('trim', Input::all()));
		//Set rules
		$rules = array(
			'issue_number' 	 => 'required|numeric|min:2|unique:comicdb_issues,issue_id,null,book_id,book_id,'.Input::get("id"),
		    'author_name' 	 => 'required|min:5',
		    'artist_name' 	 => 'required|min:5',
		    'published_date' => 'required|date_format:yy-m-d',
		    'issue_summary'  => 'max:2000',
		    'cover_image' 	 => 'required|image',
 		);
 		//Create session for data
 		$this->createSession();
 		//Set validator
		$validator = Validator::make(Input::all(), $rules);
		//Find comicbook series
		$comic_title = Comicbooks::find(Input::get('id'));
		//Check validation
		if ($validator->passes()) {
			//Instance of comicissues model
			$comic_issues = new Comicissues;
			//Set variables
			$author = Str::lower(Input::get('author_name'));		
			$artist = Str::lower(Input::get('artist_name'));
			$authorExists = Authors::where('author_name', $author)->select('id')->first();
			$artistExists = Artists::where('artist_name', $artist)->select('id')->first();

			//Check if author already exist in the database
			if(isset($authorExists)) {
				//if they do get the id
				$author_id = $authorExists->id;
			}
			else {
				//else create it in the Authors table using the instance of author model
				$author_id = Authors::insertGetId(array('author_name'=>$author));
			}

			//Check if artist already exist in the database
			if(isset($artistExists)) {
				//if they do get the id
				$artist_id = $artistExists->id;
			} else  {
				//else create it in the Artists table using the instance of artist model
				$artist_id = Artists::insertGetId(array('artist_name'=>$artist));
			}

			//Add cover image to local file and set location string into database
			if (Input::hasFile('cover_image'))
			{
				$fileName = $comic_title->book_name.Input::get('issue_number').'_Cov_'.Str::random(10).'.'.Input::file('cover_image')->getClientOriginalExtension();
				$cover_image = Input::file('cover_image')->move('public/img/comic_covers/', $fileName);
			}

			//Add book series information to comicdb_books
			$comic_issues->book_id = Input::get('id');
			$comic_issues->issue_id = Input::get('issue_number');
			$comic_issues->author_id_FK = $author_id;
			$comic_issues->artist_id_FK = $artist_id;
			$comic_issues->summary = Input::get('issue_summary');
			$comic_issues->published_date = Input::get('published_date');
			$comic_issues->cover_image = 'img/comic_covers/'.$fileName;
			$comic_issues->save();

			//Destroy session
			$this->destorySession();

			return Redirect::to('browse/series/'.$comic_title->book_name)->with('postMsg', 'Thanks for submiting!');
		} else {
			return Redirect::to('content/issue/create')->with('postMsg', 'Whoops! Looks like you got some errors.')->withErrors($validator)->withInput();
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//Get book name from session 
		$title = Session::get('book_title');
		//Set variables
		$data['issue_id'] = $id;
		$book_id = Comicbooks::series($title)->select('comicdb_books.id')->first();
		$book_issue = Comicissues::issues($title, $id)->select('book_id', 'issue_id')->first();
		//If book issue exists, then get data for it
		if (!is_null($book_issue))
		{
			$data['book_title'] = '<em>'.Str::upper($title).'</em>';
			$data['book_id'] = Comicbooks::series($title)->select('comicdb_books.id')->first();
			$data['book_info'] =Comicissues::issues($title, $id)->select('issue_id', 'summary', 'published_date', 'cover_image', 'artist_name', 'author_name')
											->distinct()->get();
			$this->layout->content = View::make('editissues', $data);
		}
		else 
		{
			return Redirect::to('browse')->with('postMsg', 'Looks like that issue does not exist! Please check out any other titles here.');
		}
	}


	/**
	 * Update an issue in the database
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//Trim inputs
		Input::merge(array_map('trim', Input::all()));
		//Set rules
		$rules = array(
		    'author_name' 	 => 'required|min:5',
		    'artist_name' 	 => 'required|min:5',
		    'published_date' => 'required|date_format:yy-m-d',
		    'issue_summary'  => 'max:2000'
 		);
 		//Create session
 		$this->createSession();
 		//Set validator
 		$validator = Validator::make(Input::all(), $rules);
 		//Set variables
 		$data['issue_id'] = $id;
		$comic_title = Comicbooks::find(Input::get('id'));
		$comic_issues = Comicissues::issues($comic_title, $id)->select('book_id', 'issue_id')->first();
		//If comicbook issue exists
		if (!is_null($comic_issues))
		{
			//Validation check
			if ($validator->passes()) {
				//Instance of Comicissue model
				$comic_issues = new Comicissues;
				//Set variables
				$author = Str::lower(Input::get('author_name'));		
				$artist = Str::lower(Input::get('artist_name'));
				$authorExists = Authors::where('author_name', $author)->select('id')->first();
				$artistExists = Artists::where('artist_name', $artist)->select('id')->first();
				
				//Check if author already exist in the database
				if(isset($authorExists)) {
					//if they do get the id
					$author_id = $authorExists->id;
				}
				else {
					//else create it in the Authors table using the instance of author model
					$author_id = Authors::insertGetId(array('author_name'=>$author));
				}

				//Check if artist already exist in the database
				if(isset($artistExists)) {
					//if they do get the id
					$artist_id = $artistExists->id;
				} else  {
					//else create it in the Artists table using the instance of artist model
					$artist_id = Artists::insertGetId(array('artist_name'=>$artist));
				}

				//Set an array of update variables
				$update_array = array(	 
						 				'author_id_FK'=> $author_id, 
						 				'artist_id_FK' => $artist_id,
						 				'summary' => Input::get('issue_summary'),
						 				'published_date' => Input::get('published_date'),
						 				'updated_at' => date('Y-m-d H:i:s', time())			 				);

				//Add cover image to local file and set location string into database
				if (Input::hasFile('cover_image'))
				{
					$fileName =  $comic_title->book_name.$id.'_Cov_'.Str::random(10).'.'.Input::file('cover_image')->getClientOriginalExtension();
					$cover_image = Input::file('cover_image')->move('public/img/comic_covers/', $fileName);
					$update_array['cover_image'] = 'img/comic_covers/'.$fileName;
				}

				//Add issue information to comicdb_books
				Comicissues::where('book_id', Input::get('id'))->where('issue_id', $id)->update($update_array);

				//Destroy session data
				$this->destorySession();
				return Redirect::to('browse/series/'.$comic_title->book_name)->with('postMsg', 'Thanks for submiting!');
			} else {
				return Redirect::to(URL::previous())->with('postMsg', 'Whoops! Looks like you got some errors.')->withErrors($validator)->withInput();
			}
		}
		$this->destorySession();
		return Redirect::to(URL::previous())->with('postMsg', 'Looks like that issue already exists!');
	}


	/**
	 * Remove an issue from the database.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//Set variables
		$msg = 'The issue has been deleted.';
		$title = Session::get('book_title');
		$data['issue_id'] = $id;
		$book_issue = Comicissues::issues($title, $id)->select('book_id', 'issue_id')->first();
		//Check if comicbook issue exists
		if (!is_null($book_issue)) {
			//Get the number of issues are in this series
			$count = Comicissues::issuescount($title)->count();
			//If there's only one issue in the series, delete the whole series
			if ($count<=1) {
				$content = new ContentController();
				$content->destroy($title);
				$msg = 'The series and issue has been deleted.';
			}
			//Delete issue
			Comicissues::where('book_id', $book_issue->book_id)->where('issue_id', $book_issue->issue_id)->delete();
			return Redirect::to('browse')->with('postMsg', $msg);
		} else {
			return Redirect::to(URL::previous())->with('postMsg', 'Whoops! Looks like you got some errors.');
		}

	}

	/*
	*	Create session data
	*/
	public function createSession() {
		Session::put(array(
 				'issue_number'	 => Input::get('issue_number'),
				'author_name' 	 => Input::get('author_name'),
				'artist_name'  	 => Input::get('artist_name'),
				'published_date' => Input::get('published_date'),
				'issue_summary'  => Input::get('issue_summary')
		));
	}
	
	/*
	*	Destroy session data
	*/
	public function destorySession(){
		Session::forget('issue_number');
		Session::forget('author_name');
		Session::forget('artist_name');
		Session::forget('published_date');
		Session::forget('issue_summary');
		Session::forget('book_title');
	}

}
