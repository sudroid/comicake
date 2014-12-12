<?php

/*
 *	Routes are registered from top to the bottom. If any match is found, that 
 *	matching callback is executed, Laravel does not continue in lookup. Home 
 *	route "/" should be placed as last one, as this says there is nothing 
 *	more to lookup
 *
 * 	 NOTE: Order of the routes matters
 */


/*
*	Manually set error page with the default layout
*/
View::name('layouts.master', 'layout');
$layout = View::of('layout');

Route::get('error', function() use ($layout) {
	$data['postMsg'] = 'Sorry, looks like that doesn\'t exist!';
	return $layout->nest('content', 'error', $data);
});

//Basic POST routes
//Mark to read or not to read status
Route::post('reading/{title}', 'ReadstatusController@postReading');
//Mark as Read or Unread status
Route::post('read/{title}', 'ReadstatusController@postRead');
//Search
Route::post('search', 'SearchController@index');

//Resource route for Issue and Series, respectfully
//These are RESTful controllers built around resources
Route::resource('content/issue', 'IssueController');
Route::resource('content/series', 'ContentController');

//Browse options 
//Basic GET routes
//All but the last route line has route paramaters which is passed to the Controller method
Route::get('browse/series/{title}/{issue}', 'BrowseController@getIssues');
Route::get('browse/characters/{name}', 'BrowseController@getCharacters');
Route::get('browse/years/{year}', 'BrowseController@getYears');
Route::get('browse/genres/{name}', 'BrowseController@getGenres');
Route::get('browse/publishers/{name}', 'BrowseController@getPublishers');
Route::get('browse/artists/{name}', 'BrowseController@getArtists');
Route::get('browse/authors/{name}', 'BrowseController@getAuthors');
Route::get('browse/series/{title}', 'BrowseController@getSeries');
Route::get('browse/{category}', 'BrowseController@getBrowse');
Route::get('browse', 'BrowseController@getIndex');

//Implicit Controller for password reminder which then fires all the methods within the Reminders controller
Route::controller('password', 'RemindersController');

//Basic GET route
Route::get('/', 'HomeController@showWelcome');

//DELETE route
Route::delete('users/{id}', ['uses' => 'UsersController@destroy', 'as'=>'users.destroy']);

//Implicit Controller for User which then fires all the methods within the Users controller
Route::controller('/', 'UsersController');
