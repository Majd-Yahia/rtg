<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'email' => 'majd.m4a4@gmail.com',
            'password' => bcrypt('1212343456'),
            'name' => 'Majd Yahia',
            'age' => 27,
            'gender' => 'male',
            'phone_number' => '0796352547',
        ]);


        $user->type = "admin";
        $user->save();
    }
}
