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
                'username'      => 'adminuser',
                'password'      => Hash::make('adminpass'),
                'email'         => 'sus.chan6@gmail.com',
                'created_at'    => new DateTime,
                'updated_at'    => new DateTime
        ));
        User::create(array(
                'username'      => 'useruser',
                'password'      => Hash::make('userpass'),
                'email'         => 'shue.chan@mohawkcollege.ca',
                'created_at'    => new DateTime,
                'updated_at'    => new DateTime
        ));    
    }
}


