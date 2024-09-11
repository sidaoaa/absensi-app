<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
               'name'=>'Admin',
               'email'=>'admin@gmail.com',
               'type'=>2,
               'password'=> bcrypt('00000000'),
            ],
            [
               'name'=>'User',
               'email'=>'user@gmail.com',
               'type'=>1,
               'password'=> bcrypt('00000000'),
            ],
        ];
    
        foreach ($users as $key => $user) {
            User::create($user);
        }
    }
}
