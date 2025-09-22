<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SharedContentSeeder extends Seeder
{
    public function run(): void
    {
        $sharedEntries = [];

        // Seleciona 30 sketchbook entries aleatórios de 1 a 240
        $entryIds = range(1, 240);
        shuffle($entryIds);

        foreach ($entryIds as $entryId) {
            $possibleUsers = [2, 3, 4, 5, 6, 7];
            shuffle($possibleUsers);
            $userIds = array_slice($possibleUsers, 0, rand(1, 4)); // 1 a 4 users aleatórios

            $permissions = rand(0, 1) ? 'view' : 'edit';

            $sharedEntries[] = [
                'sketchbook_entry_id' => $entryId,
                'user_ids' => json_encode($userIds),
                'permissions' => $permissions,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        DB::table('shared_contents')->insert($sharedEntries);
    }
}
