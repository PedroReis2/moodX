<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SharedContentSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('shared_contents')->insert([
            [
                'sketchbook_entry_id' => 1,
                'user_ids' => json_encode([2, 3, 4]), // array de IDs dos usuários que podem aceder
                'permissions' => 'view',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'sketchbook_entry_id' => 2,
                'user_ids' => json_encode([2]),
                'permissions' => 'edit',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'sketchbook_entry_id' => 3,
                'user_ids' => json_encode([2, 3, 6]),
                'permissions' => 'view',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
