<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SketchbookEntrySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('sketchbook_entries')->insert([
            [
                'sketchbook_id' => 1,
                'content_type' => 'image',
                'content_url' => 'uploads/sketches/vestido1.png',
                'content_text' => 'Primeiro rascunho de vestido longo para coleção primavera.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'sketchbook_id' => 1,
                'content_type' => 'image',
                'content_url' => 'uploads/sketches/mangas.png',
                'content_text' => 'Estudo de cortes e formatos para mangas bufantes.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'sketchbook_id' => 1,
                'content_type' => 'text',
                'content_url' => null,
                'content_text' => 'Notas sobre textura e caimento do linho cru em vestidos de verão.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
