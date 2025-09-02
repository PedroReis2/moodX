<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('comments')->insert([
            [
                'user_id' => 2,
                'sketchbook_entry_id' => 1,
                'comment' => 'Gostei do conceito deste vestido, talvez explorar outras cores.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 2,
                'sketchbook_entry_id' => 1,
                'comment' => 'As mangas estão muito bem desenhadas, boa ideia!',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 2,
                'sketchbook_entry_id' => 2,
                'comment' => 'O linho dá uma textura interessante, continua com os testes.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
