<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'admin', 'permission' => 'all']);
        Role::firstOrCreate(['name' => 'formador', 'permission' => 'read, comment']);
        Role::firstOrCreate(['name' => 'user', 'permission' => 'create, read, edit, comment']);
    }
}
