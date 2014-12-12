<?php

class ReadstatusController extends BaseController {
	
	//Protected variable - master layout
	protected $layout = "layouts.master";

	/*
	*	Constructor sets beforeFilters 
	*/
	public function __construct() {
		//See filters.php
		//Laravel contains a built in protectin for cross-site request forgery on POST. 
		//See filters.php
		$this->beforeFilter('csrf', array('on'=>'post'));
		//Auth filter 
		// Only users can accesss these methods (adding series to read and/or to read list)
		$this->beforeFilter('auth', array('only'=>array('postRead', 'postReading')));

	}

	/*
	*	postRead inserts/updates the Read status of a comicbook series
	*/
	public function postRead()
	{
		//Get the title from the url
		$title = urldecode(Request::segment(2));
		//Get variables
		$comic = Comicbooks::series($title)->select('comicdb_books.id')->first();
		$userExist = Userinfo::userbook(Auth::id(), $comic->id)->first();
		//If the comic exists 
		if (!is_null($comic->id)) {
			//If the user doesn't exist in the userinfo table (meaning they haven't marked anything as read/to read yet)
			if(is_null($userExist))	{
				//Add a new row of data for the user
				Userinfo::insert(array('book_id_FK' => $comic->id, 'user_id_FK' => Auth::id(), 'read_status' => Input::get('read_status')));
				return Redirect::back();
			}
			else {
				//Update the row of data for the user
				Userinfo::where('user_id_FK','=', Auth::id())->where('book_id_FK','=',$comic->id)
						->update(array('read_status' => Input::get('read_status')));
				return Redirect::back();
			}
		}
		else 
		{
			return Redirect::back()->with('postMsg', 'An error occurred. Please try again.');
		}
	}

	/*
	*	postReading inserts/updates the To Read status of a comicbook series
	*/
	public function postReading()
	{
		//Get the title from the url
		$title = urldecode(Request::segment(2));
		//Get variables
		$comic = Comicbooks::series($title)->select('comicdb_books.id')->first();
		$userExist = Userinfo::userbook(Auth::id(), $comic->id)->first();
		//If the comic exists 
		if (!is_null($comic->id))	{
			//If the user doesn't exist in the userinfo table (meaning they haven't marked anything as read/to read yet)
			if(is_null($userExist))	{
				//Add a new row of data for the user
				Userinfo::insert(array('book_id_FK' => $comic->id, 'user_id_FK' => Auth::id(), 'reading_status' => Input::get('reading_status')));
				return Redirect::back();
			}
			else {
				//Update the row of data for the user
				Userinfo::where('user_id_FK','=', Auth::id())->where('book_id_FK','=',$comic->id)
						->update( array('reading_status' => Input::get('reading_status')) );
				return Redirect::back();
			}
		}
		else 
		{
			return Redirect::back()->with('postMsg', 'An error occurred. Please try again.');
		}
	}

}