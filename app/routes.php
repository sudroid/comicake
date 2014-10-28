<?php

/*
 *	Routes are registered from top to the bottom. If any match is found, that 
 *	matching callback is executed, Laravel does not continue in lookup. Home 
 *	route "/" should be placed as last one, as this says there is nothing 
 *	more to lookup
 *
 */

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
Route::get('browse/characters/{title}', 'BrowseController@getCharacters');
Route::get('browse/year/{title}', 'BrowseController@getYears');
Route::get('browse/genre/{title}', 'BrowseController@getGenres');
Route::get('browse/publishers/{title}', 'BrowseController@getPublishers');
Route::get('browse/artists/{title}', 'BrowseController@getArtists');
Route::get('browse/authors/{title}', 'BrowseController@getAuthors');
Route::get('browse/series/{title}', 'BrowseController@getSeries');
Route::get('browse/{category}', 'BrowseController@getBrowse');
Route::get('browse', 'BrowseController@getIndex');


//Password Controller
Route::controller('password', 'RemindersController');

Route::get('/', 'HomeController@showWelcome');

//User Controller
Route::controller('/', 'UsersController');
