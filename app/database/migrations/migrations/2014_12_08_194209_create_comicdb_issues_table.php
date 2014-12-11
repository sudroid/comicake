<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateComicdbIssuesTable extends Migration {

	public function up()
	{
		Schema::create('comicdb_issues', function(Blueprint $table) {
			$table->timestamps();
			$table->integer('book_id')->unsigned();
			$table->integer('issue_id')->unsigned();
			$table->string('summary', 2000)->nullable();
			$table->datetime('published_date')->nullable();
			$table->string('cover_image', 500)->nullable();
			$table->integer('artist_id_FK')->unsigned();
			$table->integer('author_id_FK')->unsigned();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('comicdb_issues');
	}
}