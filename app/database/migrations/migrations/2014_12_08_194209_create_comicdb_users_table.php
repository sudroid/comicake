<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateComicdbUsersTable extends Migration {

	public function up()
	{
		Schema::create('comicdb_users', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('username', 11);
			$table->string('password', 70);
			$table->tinyInteger('admin')->default('0');
			$table->tinyInteger('active')->default('1');
			$table->string('email', 100);
			$table->string('remember_token', 100);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('comicdb_users');
	}
}