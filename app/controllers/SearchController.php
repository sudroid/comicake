<?php

class SearchController extends BaseController {

	protected $layout = "layouts.master";

	public function index() {
		$keyword = Str::lower(Input::get('keyword'));
		$data['comics'] 	= Comicbooks::where('book_name', 'LIKE', '%'.$keyword .'%')
									->select('book_name')->get();
		$data['characters'] = Characters::where('character_name', 'LIKE', '%'.$keyword .'%')
										->select('character_name')->get();
		$data['authors'] 	= Authors::where('author_name', 'LIKE', '%'.$keyword .'%')
									->select('author_name')->get();
		$data['artists'] 	= Artists::where('artist_name', 'LIKE', '%'.$keyword .'%')
									->select('artist_name')->get();
		$data['publishers'] = Publishers::where('publisher_name', 'LIKE', '%'.$keyword .'%')
									->select('publisher_name')->get();
		$this->layout->content = View::make('search', $data);
	}
}