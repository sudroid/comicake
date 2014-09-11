<?php

class UserController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| User Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/
	public function index()
	{
		return View::make('user');
	}
	
	public function showUser()
	{
		$user = DB::table('comicdb_user')->get();
		foreach ($users as $user)
		{
			var_dump($user->name);
		}
		return View::make('user');
	}
}
