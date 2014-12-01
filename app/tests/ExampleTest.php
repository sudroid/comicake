<?php

// Controller tests should verify responses, 
// ensure that the correct database access methods are triggered, 
// and assert that the appropriate instance variables are sent to the view.

// The process of testing a controller can be divided into three pieces.

// 1) Isolate: Mock all dependencies (perhaps excluding the View).
// 2) Call: Trigger the desired controller method.
// 3) Ensure: Perform assertions, verifying that the stage has been set properly.

//RUN --> vendor/bin/phpunit 

class ExampleTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testBasicExample()
	{
		$crawler = $this->client->request('GET', '/');

		$this->assertTrue($this->client->getResponse()->isOk());
	}


	public function testWelcomePage() {
		$this->get('/');

		$this->assertResponseOk();
	}

	public function testBrowsePages() {
		$this->get('/browse');

		$this->assertResponseOk();
	}

	public function testBrowseSeriesPage() {
		$this->get('browse/series');

		$this->assertViewHas('data');
	}

	public function testErrorPage() {
		$this->get('browse/aljdfadf'); 
		$this->assertResponseStatus(302);
	}
}
