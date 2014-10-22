<?php

class IssueController extends BaseController {
	protected $layout = "layouts.master";

	public function __construct() {

		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->beforeFilter('auth');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//nothing here
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$title = Session::get('book_title');
		if (Comicbooks::series($title)->select('comicdb_books.id')->first())
		{
			$data['book_title'] = '<em>'.strtoupper($title).'</em>';
			$data['book_id'] = Comicbooks::series($title)->select('comicdb_books.id')->first();
			$this->layout->content = View::make('addissues', $data);
		}
		else 
		{
			return Redirect::to('browse')->with('postMsg', 'Looks like that book does not exist! Please check out any other titles here.');
		}
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = array(
			'issue_number' => 'required|numeric',
		    'author_name' => 'required|min:1',
		    'artist_name' => 'required|min:1',
		    'published_date' => 'required|date_format:yy-m-d',
		    'issue_summary' => '',
		    'cover_image' => 'required|image',
 		);
 		Session::put('issue_number', Input::get('issue_number'));
 		Session::put('author_name', Input::get('author_name'));
 		Session::put('artist_name', Input::get('artist_name'));
 		Session::put('published_date', Input::get('published_date'));
 		Session::put('issue_summary', Input::get('issue_summary'));

		$validator = Validator::make(Input::all(), $rules);
		$comic_title = Comicbooks::find(Input::get('id'));
		if ($validator->passes()) {
			$comic_issues = new Comicissues;
			$author = Str::lower(Input::get('author_name'));		
			$artist = Str::lower(Input::get('artist_name'));
			$authorExists = DB::table('comicdb_authors')->where('author_name', $author)->select('id')->first();
			$artistExists = DB::table('comicdb_artists')->where('artist_name', $artist)->select('id')->first();
			
			if(isset($authorExists))
				$author_id = $authorExists->id;
			else 
				$author_id = DB::table('comicdb_authors')->insertGetId(array('author_name'=>$author));

			if(isset($artistExists))
				$artist_id = $artistExists->id;
			else 
				$artist_id = DB::table('comicdb_artists')->insertGetId(array('artist_name'=>$artist));

			if (Input::hasFile('cover_image'))
			{
				$fileName = Input::get('issue_number').'_Cov_'.Str::random(10).'.'.Input::file('cover_image')->getClientOriginalExtension();
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
			
			Session::forget('issue_number');
	 		Session::forget('author_name');
	 		Session::forget('artist_name');
	 		Session::forget('published_date');
	 		Session::forget('issue_summary');
	 		Session::forget('book_title');
			return Redirect::to('browse/series/'.$comic_title->book_name)->with('postMsg', 'Thanks for submiting!');
		} else {
			return Redirect::to('content/issue/create')->with('postMsg', 'Whoops! Looks like you got some errors.')->withErrors($validator);
		}
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$title = Session::get('book_title');
		$data['issue_id'] = $id;
		$book_id = Comicbooks::series($title)->select('comicdb_books.id')->first();
		$book_issue = Comicissues::issues($title, $id)->select('book_id', 'issue_id')->first();
		if ($book_issue)
		{
			$data['book_title'] = '<em>'.Str::upper($title).'</em>';
			$data['book_id'] = Comicbooks::series($title)->select('comicdb_books.id')->first();
			$data['book_info'] =Comicissues::issues($title, $id)->select('issue_id', 'summary', 'published_date', 'cover_image', 'artist_name', 'author_name')
											->distinct()->get();
			$this->layout->content = View::make('editissues', $data);
		}
		else 
		{
			return Redirect::to('browse')->with('postMsg', 'Looks like that book does not exist! Please check out any other titles here.');
		}
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$rules = array(

			'issue_number' => 'required|numeric',
		    'author_name' => 'required|min:1',
		    'artist_name' => 'required|min:1',
		    'published_date' => 'required|date_format:yy-m-d',
		    'issue_summary' => '',
		    'cover_image' => 'image',
 		);

 		Session::put('issue_number', Input::get('issue_number'));
 		Session::put('author_name', Input::get('author_name'));
 		Session::put('artist_name', Input::get('artist_name'));
 		Session::put('published_date', Input::get('published_date'));
 		Session::put('issue_summary', Input::get('issue_summary'));

 		//Laravel / Eloquent doesn't support composite primary keys...

 		$validator = Validator::make(Input::all(), $rules);
 		$data['issue_id'] = $id;
		$comic_title = Comicbooks::find(Input::get('id'));
		$comic_issues = Comicissues::issues($comic_title, $id)->select('book_id', 'issue_id')->first();
		if (!isset($comic_issues))
		{
			if ($validator->passes()) {
				$comic_issues = new Comicissues;
				$author = Str::lower(Input::get('author_name'));		
				$artist = Str::lower(Input::get('artist_name'));
				$authorExists = DB::table('comicdb_authors')->where('author_name', $author)->select('id')->first();
				$artistExists = DB::table('comicdb_artists')->where('artist_name', $artist)->select('id')->first();
				
				if(isset($authorExists))
					$author_id = $authorExists->id;
				else 
					$author_id = DB::table('comicdb_authors')->insertGetId(array('author_name'=>$author));

				if(isset($artistExists))
					$artist_id = $artistExists->id;
				else 
					$artist_id = DB::table('comicdb_artists')->insertGetId(array('artist_name'=>$artist));

				$update_array = array(	'issue_id' => Input::get('issue_number'), 
						 				'author_id_FK'=> $author_id, 
						 				'artist_id_FK' => $artist_id,
						 				'summary' => Input::get('issue_summary'),
						 				'published_date' => Input::get('published_date'));

				if (Input::hasFile('cover_image'))
				{
					$fileName =  Session::get('book_title').Input::get('issue_number').'_Cov_'.Str::random(10).'.'.Input::file('cover_image')->getClientOriginalExtension();
					$cover_image = Input::file('cover_image')->move('public/img/comic_covers/', $fileName);
					$update_array['cover_image'] = 'img/comic_covers/'.$fileName;
				}

				//Add issue information to comicdb_books
				Comicissues::where('book_id', Input::get('id'))->where('issue_id', Input::get('issue_number'))
							 ->update($update_array);
				

				return Redirect::to('browse/series/'.$comic_title->book_name)->with('postMsg', 'Thanks for submiting!');
			} else {
				return Redirect::to(URL::previous())->with('postMsg', 'Whoops! Looks like you got some errors.')->withErrors($validator)->withInput();
			}
		}
		Session::forget('issue_number');
 		Session::forget('author_name');
 		Session::forget('artist_name');
 		Session::forget('published_date');
 		Session::forget('issue_summary');
 		Session::forget('book_title');
		return Redirect::to(URL::previous())->with('postMsg', 'Looks like that issue already exists!');
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$title = Session::get('book_title');
		$data['issue_id'] = $id;
		$book_issue = Comicissues::issues($title, $id)->select('book_id', 'issue_id')->first();
		if ($book_issue)
		{
			Comicissues::where('book_id', $book_issue->book_id)->where('issue_id', $book_issue->issue_id)->delete();
		return Redirect::to('browse')->with('postMsg', 'The issue has been deleted.');
		} else {
			return Redirect::to(URL::previous())->with('postMsg', 'Whoops! Looks like you got some errors.');
		}

	}


}
