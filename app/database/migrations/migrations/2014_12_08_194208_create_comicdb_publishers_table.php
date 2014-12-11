<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateComicdbPublishersTable extends Migration {

	public function up()
	{
		Schema::create('comicdb_publishers', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('publisher_name', 100);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('comicdb_publishers');
	}
}