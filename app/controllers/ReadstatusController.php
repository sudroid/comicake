<?php

class ReadstatusController extends BaseController {
	
	//Protected variable - master layout
	protected $layout = "layouts.master";

	/*
	*	Constructor sets beforeFilters 
	*/
	public function __construct() {

		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->beforeFilter('auth', array('only'=>array('postRead', 'postReading')));

	}

	/*
	*	postRead inserts/updates the Read status of a comicbook series
	*/
	public function postRead()
	{
		$title = urldecode(Request::segment(2));
		$comic = Comicbooks::series($title)->select('comicdb_books.id')->first();
		$userExist = Userinfo::userbook(Auth::id(), $comic->id)->first();
		if (!is_null($comic->id))	{
			if(is_null($userExist))	{
				Userinfo::insert(array('book_id_FK' => $comic->id, 'user_id_FK' => Auth::id(), 'read_status' => Input::get('read_status')));
				return Redirect::back();
			}
			else {
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
		$title = urldecode(Request::segment(2));
		$comic = Comicbooks::series($title)->select('comicdb_books.id')->first();
		$userExist = Userinfo::userbook(Auth::id(), $comic->id)->first();
		if (!is_null($comic->id))	{
			if(is_null($userExist))	{
				Userinfo::insert(array('book_id_FK' => $comic->id, 'user_id_FK' => Auth::id(), 'reading_status' => Input::get('reading_status')));
				return Redirect::back();
			}
			else {
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