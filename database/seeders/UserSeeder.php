<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'role_id' => 1, // admin
            'name' => 'adminTest',
            'email' => 'admin@email.com',
            'password' => Hash::make('admin'),
        ]);

        User::create([
            'role_id' => 2, // formador
            'name' => 'formadorTest',
            'email' => 'formador@email.com',
            'password' => Hash::make('formador'),
        ]);

        User::create([
            'role_id' => 2, // formador
            'name' => 'formador2Test',
            'email' => 'formador2@email.com',
            'password' => Hash::make('formador'),
        ]);

        User::create([
            'role_id' => 3, // user
            'name' => 'userTest',
            'email' => 'user@email.com',
            'password' => Hash::make('user'),
        ]);

        User::create([
            'role_id' => 3, // user
            'name' => 'user1Test',
            'email' => 'user1@email.com',
            'password' => Hash::make('user'),
        ]);

        User::create([
            'role_id' => 3, // user
            'name' => 'user2Test',
            'email' => 'user2@email.com',
            'password' => Hash::make('user'),
        ]);

        User::create([
            'role_id' => 3, // user
            'name' => 'user3Test',
            'email' => 'user3@email.com',
            'password' => Hash::make('user'),
        ]);
    }
}
