<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/
	public function home()
	{
		$title = 'C O M I C A K E';
		return View::make('home')->with('title', $title);
	}
	
	public function login()
	{
		$title = 'C O M I C A K E';
		return View::make('login')->with('title', $title);
	}
}
