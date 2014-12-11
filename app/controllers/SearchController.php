<?php

class SearchController extends BaseController {
	
	//Protected variable - master layout
	protected $layout = "layouts.master";
	/*
	*	Returns the list of items that matches the search
	*/
	public function index() {
		$keyword = Str::lower(Input::get('keyword'));
		$data['comics'] 	= Comicbooks::where('book_name', 'LIKE', '%'.$keyword .'%')
									->select('book_name')->distinct()->get();
		$data['characters'] = Characters::where('character_name', 'LIKE', '%'.$keyword .'%')
										->select('character_name')->distinct()->get();
		$data['authors'] 	= Authors::where('author_name', 'LIKE', '%'.$keyword .'%')
									->select('author_name')->distinct()->get();
		$data['artists'] 	= Artists::where('artist_name', 'LIKE', '%'.$keyword .'%')
									->select('artist_name')->distinct()->get();
		$data['publishers'] = Publishers::where('publisher_name', 'LIKE', '%'.$keyword .'%')
									->select('publisher_name')->distinct()->get();
		$this->layout->content = View::make('search', $data);
	}
}