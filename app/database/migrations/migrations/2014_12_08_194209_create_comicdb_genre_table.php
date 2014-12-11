<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateComicdbGenreTable extends Migration {

	public function up()
	{
		Schema::create('comicdb_genre', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('genre_name', 100);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('comicdb_genre');
	}
}