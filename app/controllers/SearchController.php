<?php

class SearchController extends BaseController {

	protected $layout = "layouts.master";

	public function index() {
		$keyword = Str::lower(Input::get('keyword'));
		// $json = '{
		// 			"book_name": "Nothing here, man", 
		// 			"character_name": "Nothing in here either.",
		// 			"author_name" : "Yeeah, still nothing."
		// 		}';

		$data['comics'] = Comicbooks::where('book_name', 'LIKE', '%'.$keyword .'%')
									->select('book_name')->get();

		$data['characters'] = DB::table('comicdb_characters')
									->where('character_name', 'LIKE', '%'.$keyword .'%')
									->select('character_name')->get();

		$data['authors'] = DB::table('comicdb_authors')
									->where('author_name', 'LIKE', '%'.$keyword .'%')
									->select('author_name')->get();

		$data['artists'] = DB::table('comicdb_artists')
									->where('artist_name', 'LIKE', '%'.$keyword .'%')
									->select('artist_name')->get();

		$data['publishers'] = Publishers::where('publisher_name', 'LIKE', '%'.$keyword .'%')
									->select('publisher_name')->get();

		// if($data['comics'] == '[]') { $data['comics'][0] = json_decode($json); };
		// if($data['characters'] == '[]') { $data['characters'][0] = json_decode($json); };
		// if($data['authors'] == '[]') { $data['authors'][0] = json_decode($json); };
		
		$this->layout->content = View::make('search', $data);
	}
}