<?php


class UserInfo extends Eloquent {

	protected $table = 'comicdb_userinfo';

	public function scopeUserbook($query, $user_id, $book_id){
		return $query->where('user_id_FK', '=', $user_id)->where('book_id_FK', '=', $book_id);
	}

	public function scopeUserbookread($query, $user_id){
		return $query->join('comicdb_books', 'comicdb_books.id', '=', 'comicdb_userinfo.book_id_FK')
					 ->where('user_id_FK', $user_id);
	}

	public function scopeUserReadPublisher($query, $user_id) {
		return $query->join('comicdb_books', 'comicdb_books.id', '=', 'comicdb_userinfo.book_id_FK')
					 ->join('comicdb_publishers', 'comicdb_books.publisher_id_FK', '=', 'comicdb_publishers.id')
					 ->where('user_id_FK', $user_id);
	}

	public function scopeUserReadGenre($query, $user_id) {
		return $query->join('comicdb_books', 'comicdb_books.id', '=', 'comicdb_userinfo.book_id_FK')
					 ->join('comicdb_genrebook', 'comicdb_books.id', '=', 'comicdb_genrebook.book_id_FK')
					 ->join('comicdb_genre', 'comicdb_genrebook.genre_id_FK', '=', 'comicdb_genre.id')
					 ->where('user_id_FK', $user_id);
	}

	public function scopeDeleteUser($query, $user_id) {
		return $query->where('user_id_FK', $user_id)->delete();
	}
}