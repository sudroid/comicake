<?php

//Add Controller
Route::resource('post', 'PostController');

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

Route::controller('/', 'UsersController');
