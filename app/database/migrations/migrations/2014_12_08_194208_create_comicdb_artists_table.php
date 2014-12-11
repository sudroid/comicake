<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateComicdbArtistsTable extends Migration {

	public function up()
	{
		Schema::create('comicdb_artists', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('artist_name', 100);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('comicdb_artists');
	}
}