<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //delete users table records
        DB::table('users')->delete();


        DB::table('users')->insert(array(
            [
                "name" => "UT Admin",
                "username" => "admin",
                "password" => bcrypt("tehran@123"),
                "is_admin" => true
            ],
            [
                "name" => "Test User",
                "username" => "test",
                "password" => bcrypt("123"),
                "is_admin" => false
            ]
        ));
    }
}
