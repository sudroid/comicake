<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('UserTableSeeder');
	}

}

class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('comicdb_users')->delete();
        User::create(array(
                'userID' => 1,
                'username' => 'tester',
                'password' => Hash::make('mypass1'),
                'userSQ' => Hash::make('your birthday year is?'),
				'userSA' => Hash::make('1989'),
                'created_at' => new DateTime,
                'updated_at' => new DateTime
        ));
        User::create(array(
                'userID' => 2,
                'username' => 'tester2',
                'password' => Hash::make('mypass2'),
                'userSQ' => Hash::make('your birthday year is?'),
				'userSA' => Hash::make('none of your business'),
                'created_at' => new DateTime,
                'updated_at' => new DateTime
        ));    
    }
}
