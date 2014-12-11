<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('comicdb_books', function(Blueprint $table) {
			$table->foreign('publisher_id_FK')->references('id')->on('comicdb_publishers')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('comicdb_characterbook', function(Blueprint $table) {
			$table->foreign('book_id_FK')->references('id')->on('comicdb_books')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('comicdb_characterbook', function(Blueprint $table) {
			$table->foreign('character_id_FK')->references('id')->on('comicdb_characters')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('comicdb_genrebook', function(Blueprint $table) {
			$table->foreign('book_id_FK')->references('id')->on('comicdb_books')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('comicdb_genrebook', function(Blueprint $table) {
			$table->foreign('genre_id_FK')->references('id')->on('comicdb_genre')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('comicdb_issues', function(Blueprint $table) {
			$table->foreign('book_id')->references('id')->on('comicdb_books')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('comicdb_issues', function(Blueprint $table) {
			$table->foreign('artist_id_FK')->references('id')->on('comicdb_artists')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('comicdb_issues', function(Blueprint $table) {
			$table->foreign('author_id_FK')->references('id')->on('comicdb_authors')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('comicdb_userinfo', function(Blueprint $table) {
			$table->foreign('user_id_FK')->references('id')->on('comicdb_users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('comicdb_userinfo', function(Blueprint $table) {
			$table->foreign('book_id_FK')->references('id')->on('comicdb_books')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
	}

	public function down()
	{
		Schema::table('comicdb_books', function(Blueprint $table) {
			$table->dropForeign('comicdb_books_publisher_id_FK_foreign');
		});
		Schema::table('comicdb_characterbook', function(Blueprint $table) {
			$table->dropForeign('comicdb_characterbook_book_id_FK_foreign');
		});
		Schema::table('comicdb_characterbook', function(Blueprint $table) {
			$table->dropForeign('comicdb_characterbook_character_id_FK_foreign');
		});
		Schema::table('comicdb_genrebook', function(Blueprint $table) {
			$table->dropForeign('comicdb_genrebook_book_id_FK_foreign');
		});
		Schema::table('comicdb_genrebook', function(Blueprint $table) {
			$table->dropForeign('comicdb_genrebook_genre_id_FK_foreign');
		});
		Schema::table('comicdb_issues', function(Blueprint $table) {
			$table->dropForeign('comicdb_issues_book_id_foreign');
		});
		Schema::table('comicdb_issues', function(Blueprint $table) {
			$table->dropForeign('comicdb_issues_artist_id_FK_foreign');
		});
		Schema::table('comicdb_issues', function(Blueprint $table) {
			$table->dropForeign('comicdb_issues_author_id_FK_foreign');
		});
		Schema::table('comicdb_userinfo', function(Blueprint $table) {
			$table->dropForeign('comicdb_userinfo_user_id_FK_foreign');
		});
		Schema::table('comicdb_userinfo', function(Blueprint $table) {
			$table->dropForeign('comicdb_userinfo_book_id_FK_foreign');
		});
	}
}