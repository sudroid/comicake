<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateComicdbBooksTable extends Migration {

	public function up()
	{
		Schema::create('comicdb_books', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('book_name', 255);
			$table->string('book_description', 2000)->nullable();
			$table->integer('publisher_id_FK')->unsigned();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('comicdb_books');
	}
}