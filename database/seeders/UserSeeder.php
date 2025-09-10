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
            'first_name' => 'Admin',
            'last_name' => 'Test',
            'name' => 'adminTest',
            'email' => 'admin@email.com',
            'password' => Hash::make('admin'),
        ]);

        User::create([
            'role_id' => 2, // formador
            'first_name' => 'Formador',
            'last_name' => 'Test',
            'name' => 'formadorTest',
            'email' => 'formador@email.com',
            'password' => Hash::make('formador'),
        ]);

        User::create([
            'role_id' => 2, // formador
            'first_name' => 'Formador2',
            'last_name' => 'Test',
            'name' => 'formador2Test',
            'email' => 'formador2@email.com',
            'password' => Hash::make('formador'),
        ]);

        User::create([
            'role_id' => 3, // user
            'first_name' => 'User',
            'last_name' => 'Test',
            'name' => 'userTest',
            'email' => 'user@email.com',
            'password' => Hash::make('user'),
        ]);

        User::create([
            'role_id' => 3, // user
            'first_name' => 'User1',
            'last_name' => 'Test',
            'name' => 'user1Test',
            'email' => 'user1@email.com',
            'password' => Hash::make('user'),
        ]);

        User::create([
            'role_id' => 3, // user
            'first_name' => 'User2',
            'last_name' => 'Test',
            'name' => 'user2Test',
            'email' => 'user2@email.com',
            'password' => Hash::make('user'),
        ]);

        User::create([
            'role_id' => 3, // user
            'first_name' => 'User3',
            'last_name' => 'Test',
            'name' => 'user3Test',
            'email' => 'user3@email.com',
            'password' => Hash::make('user'),
        ]);
    }
}
