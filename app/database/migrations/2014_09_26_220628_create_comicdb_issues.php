<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComicdbIssues extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('comicdb_issues', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('author', 500);
			$table->string('artist', 500);
			$table->date('published_date', 500);
			$table->string('summary', 1500);
			$table->timestamp('created_at');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		Schema::drop('comicdb_issues');
	}

}
