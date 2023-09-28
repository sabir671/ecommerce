<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin=User::create([
            'name'=>'admin2',
            'email'=>'admin2@gmail.com',
            'password'=>Hash::make('12345678'),

        ]);
        $admin->assignRole('admin');

        $user=user::create([
            'name'=>'user2' ,
            'email'=>'user2@gmail.com',
            'password'=>Hash::make('12345678'),

        ]);
        $user->assignRole('user');
    }


}
