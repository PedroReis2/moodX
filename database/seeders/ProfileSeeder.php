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
            // admin
            [
                'user_id' => 1,
                'bio' => 'Administrador da plataforma Modatex.',
                'avatar' => 'profile-pics/1.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // formador
            [
                'user_id' => 2,
                'bio' => 'Formador de design de moda especializado em tecidos.',
                'avatar' => 'profile-pics/2.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // formador 2
            [
                'user_id' => 3,
                'bio' => 'Formador de design de moda especializado em design',
                'avatar' => 'profile-pics/3.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // user 1
            [
                'user_id' => 4,
                'bio' => 'Estudante interessado em moda sustentável.',
                'avatar' => 'profile-pics/4.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // user 2
            [
                'user_id' => 5,
                'bio' => 'Estudante interessado em moda sustentável.',
                'avatar' => 'profile-pics/5.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // user 3
            [
                'user_id' => 6,
                'bio' => 'Estudante interessado em moda sustentável.',
                'avatar' => 'profile-pics/6.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // user 4
            [
                'user_id' => 7,
                'bio' => 'Estudante interessado em moda sustentável.',
                'avatar' => 'profile-pics/7.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
