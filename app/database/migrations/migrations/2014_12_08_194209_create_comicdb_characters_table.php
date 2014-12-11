<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateComicdbCharactersTable extends Migration {

	public function up()
	{
		Schema::create('comicdb_characters', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('character_name', 100);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('comicdb_characters');
	}
}