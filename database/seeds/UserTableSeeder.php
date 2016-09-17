<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->delete();
	    User::create([
	        'name' => 'admin',
	        'email' => 'admin@smaap.com',
	        'password' => bcrypt('admin@smaap'),
            'birthday' => '1993-04-01',
            'gender' => 'male',
            'phone' => '8050777709'
            'profile'=> 'default.jpg';
               
	       	]);
    }
}
