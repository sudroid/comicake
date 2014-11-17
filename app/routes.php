<?php

/*
 *	Routes are registered from top to the bottom. If any match is found, that 
 *	matching callback is executed, Laravel does not continue in lookup. Home 
 *	route "/" should be placed as last one, as this says there is nothing 
 *	more to lookup
 *
 */

View::name('layouts.master', 'layout');
$layout = View::of('layout');

Route::get('error', function() use ($layout) {
	$data['postMsg'] = 'Sorry, looks like that doesn\'t exist!';
	return $layout->nest('content', 'error', $data);
});

//Mark to read or not to read status
Route::post('reading/{title}', 'ReadstatusController@postReading');
//Mark as Read or Unread status
Route::post('read/{title}', 'ReadstatusController@postRead');
//Search
Route::post('search', 'SearchController@index');

//Resource route for Issue
Route::resource('content/issue', 'IssueController');
//Resource route for Series
Route::resource('content/series', 'ContentController');

//Browse options 
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


//Password Controller
Route::controller('password', 'RemindersController');

Route::get('/', 'HomeController@showWelcome');

//User Controller
Route::controller('/', 'UsersController');
