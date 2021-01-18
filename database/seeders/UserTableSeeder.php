<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'name'=>'harvey',
            'email'=> 'aparece@gmail.com',
            'password' => Hash::make('password')
        ]);
    }
}

//watch this video tutorial
//https://www.youtube.com/watch?v=hayHnHx83eg

