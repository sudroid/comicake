<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('comicdb_users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('password', 11);
    		$table->string('email', 100)->unique();
			$table->tinyInteger('isAdmin')->default(0);
			$table->tinyInteger('activityStatus')->default(1);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('comicdb_users');
	}

}
