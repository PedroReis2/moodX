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
                'avatar' => 'https://static.wikia.nocookie.net/naruto/images/2/27/Kakashi_Hatake.png/revision/latest/smart/width/250/height/250?cb=20230803224121',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // formador
            [
                'user_id' => 2,
                'bio' => 'Formador de design de moda especializado em tecidos.',
                'avatar' => 'https://static.wikia.nocookie.net/naruto/images/2/21/Sasuke_Part_1.png/revision/latest/smart/width/250/height/250?cb=20170716092103',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // formador 2
            [
                'user_id' => 3,
                'bio' => 'Formador de design de moda especializado em design',
                'avatar' => 'https://qph.cf2.quoracdn.net/main-qimg-74d20c2dc69282251163e662950e1618-lq',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // user 1
            [
                'user_id' => 4,
                'bio' => 'Estudante interessado em moda sustentável.',
                'avatar' => 'https://images.immediate.co.uk/production/volatile/sites/3/2023/03/3e3d2-clickwallpapers-madara-uchiha-img3-scaled-Cropped-a3f2024.jpg?quality=90&resize=980,654',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // user 2
            [
                'user_id' => 5,
                'bio' => 'Estudante interessado em moda sustentável.',
                'avatar' => 'https://static0.cbrimages.com/wordpress/wp-content/uploads/2024/10/10-naruto-characters-inspired-by-japanese-folklore.jpg?q=70&fit=contain&w=1200&h=628&dpr=1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // user 3
            [
                'user_id' => 6,
                'bio' => 'Estudante interessado em moda sustentável.',
                'avatar' => 'https://studybreaks.com/wp-content/uploads/2023/08/Hinata_Part_II.webp',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // user 4
            [
                'user_id' => 7,
                'bio' => 'Estudante interessado em moda sustentável.',
                'avatar' => 'https://www.dexerto.com/cdn-image/wp-content/uploads/2023/04/18/Sakura-From-Naruto.jpeg?width=1200&quality=60&format=auto',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
