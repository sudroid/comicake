<?php

Route::get('browse/year/{title}', 'BrowsingController@getYears');
Route::get('browse/genre/{title}', 'BrowsingController@getGenres');
Route::get('browse/publishers/{title}', 'BrowsingController@getPublishers');
Route::get('browse/artists/{title}', 'BrowsingController@getArtists');
// Route::get('browse/authors/{title}', 'BrowsingController@getAuthors');
Route::get('browse/series/{title}', 'BrowsingController@getSeries');

Route::get('browse', 'BrowseController@index');

Route::controller('browse', 'BrowseController');

Route::controller('password', 'RemindersController');

Route::get('/', 'HomeController@showWelcome');

Route::controller('/', 'UsersController');
