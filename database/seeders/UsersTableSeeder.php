<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //create multiple users
        DB::table('users')->insert([
            [
                 'username'=> 'arrojado@gmail.com',
                 'password'=> bcrypt('abcd1234'),
                 'created_at'=> date('Y-m-d H:i:s')
            ],

            [
                 'username'=> 'renato@gmail.com',
                 'password'=> bcrypt('abcd1234'),
                 'created_at'=> date('Y-m-d H:i:s')
            ],

            [
                 'username'=> 'vilma@gmail.com',
                 'password'=> bcrypt('abcd1234'),
                 'created_at'=> date('Y-m-d H:i:s')
            ],

            [
                 'username'=> 'lisa@gmail.com',
                 'password'=> bcrypt('abcd1234'),
                 'created_at'=> date('Y-m-d H:i:s')
            ]

        ]);
    }
}
