<?php

use Illuminate\Database\Seeder;
use PYSCore\User;
// composer require laracasts/testdummy
//use Laracasts\TestDummy\Factory as TestDummy;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $user = User::create(array(
            'name' => 'SexyDragon',
            'email' => 'ntvinh.it@gmail.com',
            'password' => \Hash::make('sexydragon@123')
        ));
        $user->makeRole('super_admin');
    }
}
