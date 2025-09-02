<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AiRequestSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('ai_requests')->insert([
            [
                'user_id' => 5,
                'input_text' => 'Gerar variações de vestido com padrão floral em tons pastel.',
                'input_url' => null,
                'ai_output' => '3 variações sugeridas com diferentes cortes e flores estilizadas.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 5,
                'input_text' => 'Sugere combinações de tecidos sustentáveis para verão.',
                'input_url' => null,
                'ai_output' => 'Algodão orgânico, linho reciclado e cânhamo como alternativas viáveis.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 5,
                'input_text' => 'Cria variações do casaco com mangas assimétricas.',
                'input_url' => 'uploads/requests/casaco.png',
                'ai_output' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 5,
                'input_text' => 'Sugere combinações de cores para acessórios de outono.',
                'input_url' => null,
                'ai_output' => 'Tons terrosos combinados com acentos em laranja e vinho.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 5,
                'input_text' => 'Gera padrões geométricos para estampas de camisolas.',
                'input_url' => null,
                'ai_output' => 'Três padrões geométricos: losangos, triângulos sobrepostos e linhas diagonais repetidas.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 5,
                'input_text' => 'Cria propostas de logotipo para coleção de verão.',
                'input_url' => null,
                'ai_output' => 'Sugestões com tipografia leve, cores pastéis e ícones de sol e mar.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
