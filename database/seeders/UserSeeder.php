<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'=> 'admin',
            'email'=> 'admin@mail.com',
            'password'=> Hash::make('12345678'),
            'level'=> 'admin'
        ]);

        User::create([
            'name'=> 'Kepala Kantor Pusat',
            'email'=> 'kapus@mail.com',
            'password'=> Hash::make('12345678'),
            'level'=> 'approver'
        ]);

        User::create([
            'name'=> 'Kepala Kantor Cabang',
            'email'=> 'kacab@mail.com',
            'password'=> Hash::make('12345678'),
            'level'=> 'approver'
        ]);

        // User::create([
        //     'name'=> 'Driver 1',
        //     'email'=> 'driver1@mail.com',
        //     'password'=> Hash::make('12345678'),
        //     'level'=> 'driver'
        // ]);
    }
}
