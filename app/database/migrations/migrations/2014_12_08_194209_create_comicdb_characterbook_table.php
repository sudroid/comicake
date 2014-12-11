<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateComicdbCharacterbookTable extends Migration {

	public function up()
	{
		Schema::create('comicdb_characterbook', function(Blueprint $table) {
			$table->timestamps();
			$table->integer('book_id_FK')->unsigned();
			$table->integer('character_id_FK')->unsigned();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('comicdb_characterbook');
	}
}