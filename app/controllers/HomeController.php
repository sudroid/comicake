<?php

class HomeController extends BaseController {
	
	//Protected variable - master layout
	protected $layout = "layouts.master";
	
	/*
	* 	Shows the welcome page
	*/
	public function showWelcome()
	{
		$this->layout->content = View::make('home');
	}

}
