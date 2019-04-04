<?php

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
        //
        DB::table("users")->insert([
          // admin
          [
            "name" => "YAP CHENG WEI",
            "email" => "yapchengwei@gmail.com",
            "password" => bcrypt(1233),
            "role_id" => 1,
            "birthday" => date("Y-m-d H:i:s", strtotime("1994-06-06")),
            "gender" => "M"
          ]
        ]);
    }
}
