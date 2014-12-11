<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateComicdbAuthorsTable extends Migration {

	public function up()
	{
		Schema::create('comicdb_authors', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('author_name', 100);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('comicdb_authors');
	}
}