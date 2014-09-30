<?php

Route::get('browse', 'BrowseController@index');

Route::controller('browse', 'BrowseController');

Route::controller('password', 'RemindersController');

Route::get('/', 'HomeController@showWelcome');

Route::controller('/', 'UsersController');
