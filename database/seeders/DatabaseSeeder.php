<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            AiRequestSeeder::class,
            CommentSeeder::class,
            ProfileSeeder::class,
            SharedContentSeeder::class,
            SketchbookSeeder::class,
            SketchbookEntrySeeder::class,
        ]);
    }
}
