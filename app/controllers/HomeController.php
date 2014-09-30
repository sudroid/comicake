<?php

class HomeController extends BaseController {

	protected $layout = "layouts.master";

	public function showWelcome()
	{
		$this->layout->content = View::make('home');
	}

}
