<?php

class BrowseController extends BaseController {
	protected $layout = "layouts.master";
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$randomNum = rand(1, 4);
		$data['title'] = "The latest...";
		$data['comics'] = Comicdb::paginate(4);
		$this->layout->content = View::make('browse', $data);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getSeries()
	{
		/* TODO:
		*	Get all series -> issues 
		*/
		$data['title'] = 'SERIES';
		$data['comics'] = DB::table('comicdb_books')->get();
		$this->layout->content = View::make('browse', $data);
	}

	public function getAuthors()
	{
		/* TODO:
		*	Get all series by x author -> series -> issues
		*/
		$data['title'] = 'AUTHORS';
		$data['comics'] = DB::table('comicdb_authors')->get();
		$this->layout->content = View::make('browse', $data);
	}

	public function getArtists()
	{
		/* TODO:
		*	Get all series by x artist -> series -> issues
		*/
		$data['title'] = 'ARTISTS';
		$data['comics'] = DB::table('comicdb_artists')->get();
		$this->layout->content = View::make('browse', $data);
	}

	public function getCharacters()
	{
		/* TODO:
		*	Get all series by x publisher -> series -> issues
		*/
		$data['title'] = 'CHARACTERS';
		$data['comics'] = DB::table('comicdb_characters')->get();
		$this->layout->content = View::make('browse', $data);
	}

	public function getPublishers()
	{
		/* TODO:
		*	Get all series by x publisher -> series -> issues
		*/
		$data['title'] = 'PUBLISHERS';
		$data['comics'] = DB::table('comicdb_publishers')->get();
		$this->layout->content = View::make('browse', $data);
	}

	public function getGenre()
	{
		/* TODO:
		*	Get all series with x genre -> series -> issues
		*/
		$data['title'] = 'GENRE';
		$data['comics'] = DB::table('comicdb_genre')->get();
		$this->layout->content = View::make('browse', $data);
	}

	public function getYear()
	{
		/* TODO:
		*	Get all series published in x year -> series -> issues
		*/
		$data['title'] = 'YEAR';
		$date = "2014";
 		$my_date = date('yyyy', strtotime($date));
		$data['comics'] = Comicdb::where('published_date', '>', $my_date)->get();
		$this->layout->content = View::make('browse', $data);
	}
}
