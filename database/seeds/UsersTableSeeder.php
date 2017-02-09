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
                "name" => "Test User1",
                "username" => "test1",
                "password" => bcrypt("123"),
                "is_admin" => false
            ],
            [
                "name" => "Test User2",
                "username" => "test2",
                "password" => bcrypt("123"),
                "is_admin" => false
            ],
            [
                "name" => "Test User3",
                "username" => "test3",
                "password" => bcrypt("123"),
                "is_admin" => false
            ],
            [
                "name" => "Test User4",
                "username" => "test4",
                "password" => bcrypt("123"),
                "is_admin" => false
            ]
        ));
    }
}
