<?php

Route::get('/', 'HomeController@home');
Route::get('/login', 'HomeController@login');
Route::get('/user', 'UserController@showUser');