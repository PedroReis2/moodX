<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $comments = [];
        $users = range(1, 7);
        $entries = range(1, 180);
        $sampleComments = [
    'Adorei o padrão e a textura.',
    'Talvez experimentar outras cores.',
    'O caimento está muito natural.',
    'A combinação de materiais ficou ótima.',
    'As proporções estão muito bem equilibradas.',
    'Poderia explorar um corte mais ousado.',
    'A simplicidade valoriza a peça.',
    'Gostei do contraste, dá energia ao design.',
    'O detalhe nos bolsos é muito interessante.',
    'A escolha de cores transmite personalidade.',
    'A fluidez deste tecido é impressionante.',
    'As mangas têm um desenho elegante.',
    'O padrão transmite movimento.',
    'As sobreposições criam profundidade visual.',
    'A gola poderia ter um design diferente.',
    'A peça tem um ar futurista.',
    'As assimetrias dão dinamismo.',
    'O look transmite leveza e conforto.',
    'A silhueta está muito bem valorizada.',
    'O design é versátil e moderno.',
    'As linhas curvas dão suavidade ao design.',
    'O detalhe nos ombros é muito sofisticado.',
    'A escolha do tecido cria um efeito visual único.',
    'Poderia testar um comprimento diferente.',
    'A cor complementar realça o conjunto.',
    'Os acabamentos estão impecáveis.',
    'O estilo minimalista funciona muito bem.',
    'As texturas contrastantes são interessantes.',
    'O corte ajusta-se perfeitamente à silhueta.',
    'O movimento do tecido transmite leveza.',
    'A mistura de estampas ficou harmoniosa.',
    'Os botões acrescentam um toque de elegância.',
    'O design é moderno e funcional.',
    'A peça poderia ganhar mais volume nas mangas.',
    'As costuras são muito bem detalhadas.',
    'O padrão geométrico é muito cativante.',
    'A combinação de cores transmite frescura.',
    'O vestido tem um ar elegante e delicado.',
    'O decote valoriza o design.',
    'A escolha do material confere durabilidade.'
    ];

        foreach ($entries as $entry) {
            $numComments = rand(2, 5); // 2 a 5 comentários por entry
            for ($i = 0; $i < $numComments; $i++) {
                $comments[] = [
                    'user_id' => $users[array_rand($users)],
                    'sketchbook_entry_id' => $entry,
                    'comment' => $sampleComments[array_rand($sampleComments)],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
        }

        DB::table('comments')->insert($comments);
    }
}
