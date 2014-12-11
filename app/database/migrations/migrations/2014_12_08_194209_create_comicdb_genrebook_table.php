<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateComicdbGenrebookTable extends Migration {

	public function up()
	{
		Schema::create('comicdb_genrebook', function(Blueprint $table) {
			$table->timestamps();
			$table->integer('book_id_FK')->unsigned();
			$table->integer('genre_id_FK')->unsigned();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('comicdb_genrebook');
	}
}