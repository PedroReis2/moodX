<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProfileSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('profiles')->insert([
            [
                'user_id' => 1,
                'bio' => 'Administrador da plataforma Modatex.',
                'avatar' => 'uploads/avatars/admin.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 2,
                'bio' => 'Formador de design de moda especializado em tecidos.',
                'avatar' => 'uploads/avatars/formador.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 5,
                'bio' => 'Estudante interessado em moda sustentável.',
                'avatar' => 'uploads/avatars/formando.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
