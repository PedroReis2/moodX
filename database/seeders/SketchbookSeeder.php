<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SketchbookSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('sketchbooks')->insert([
            [
                'user_id' => 5,
                'title' => 'Coleção Primavera 2025',
                'description' => 'Sketchbook para ideias iniciais da coleção de primavera.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 5,
                'title' => 'Tecidos e Texturas',
                'description' => 'Exploração de tecidos e padrões para casacos e saias.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 5,
                'title' => 'Moda Sustentável',
                'description' => 'Registo de experimentos com materiais reciclados.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
