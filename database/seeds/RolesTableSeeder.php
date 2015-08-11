<?php

use Illuminate\Database\Seeder;
use PYSCore\Role;
// composer require laracasts/testdummy
//use Laracasts\TestDummy\Factory as TestDummy;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $roles_name = array(
            'add_user',
            'update_user',
            'delete_user',
            'add_tour',
            'delete_tour',
            'update_tour',
            'add_booking',
            'update_booking',
            'delete_booking',
            'update_user_role'
        );

        foreach($roles_name as $role) {
            Role::create(array('name' => $role));
        }
    }
}
