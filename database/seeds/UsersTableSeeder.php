<?php

use Illuminate\Database\Seeder;
use App\Common\Roles;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
                [
                'name' => 'Admin',
                'user_name' =>'admin',
                'email' =>'admin@gmail.com',
                'mobile_no' =>'9496243903',
                'role' =>Roles::ROLE_ADMIN,
                'status' =>1,
                'password' => bcrypt('Secret123'),
                ]

           ]);
    }
}
