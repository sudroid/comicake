<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateComicdbUserinfoTable extends Migration {

	public function up()
	{
		Schema::create('comicdb_userinfo', function(Blueprint $table) {
			$table->tinyInteger('read_status')->default('1');
			$table->integer('user_id_FK')->unsigned();
			$table->integer('book_id_FK')->unsigned();
			$table->tinyInteger('reading_status');
			$table->timestamps();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('comicdb_userinfo');
	}
}