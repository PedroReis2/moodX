<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SketchbookSeeder extends Seeder
{
    public function run(): void
    {
        $users = [4, 5, 6, 7];
        $titles = [
            'Estilos Urbanos Contemporâneos',
            'Cores e Texturas Outono/Inverno',
            'Tendências de Moda 2025',
            'Moda Minimalista',
            'Estilo Boho Chic',
            'Coleção de Verão 2025',
            'Inspirações de Street Style',
            'Moda Sustentável',
            'Estilo Vintage',
            'Tendências de Acessórios',
            'Coleção de Inverno 2025',
            'Estilo Clássico',
            'Moda de Rua',
            'Estilo Romântico',
            'Coleção de Primavera 2025',
            'Estilo Grunge',
            'Moda Futurista',
            'Estilo Retrô',
            'Coleção de Outono 2025',
            'Estilo Preppy'
        ];
        $descriptions = [
            'Exploração de estilos urbanos modernos.',
            'Combinação de cores e texturas para a estação.',
            'Análise das tendências de moda para o próximo ano.',
            'Design minimalista com foco na simplicidade.',
            'Inspiração no estilo boêmio e descontraído.',
            'Coleção inspirada nas cores e tecidos de verão.',
            'Estudo de looks de rua e influências urbanas.',
            'Moda consciente com foco em sustentabilidade.',
            'Revival de peças e estilos do passado.',
            'Análise de acessórios que estão em alta.',
            'Coleção inspirada nas cores e tecidos de inverno.',
            'Estilo clássico com peças atemporais.',
            'Looks inspirados na moda de rua.',
            'Estilo romântico com peças delicadas.',
            'Coleção inspirada nas flores e cores da primavera.',
            'Estilo grunge com influências dos anos 90.',
            'Design futurista com cortes e tecidos inovadores.',
            'Revival de estilos dos anos 70.',
            'Coleção inspirada nas cores e tecidos de outono.',
            'Estilo preppy com influências universitárias.'
        ];
$images = [
'https://www.shutterstock.com/image-vector/fashion-figure-illustration-female-vector-600nw-2500828911.jpg',
'https://i.pinimg.com/236x/f6/04/51/f604513910f20a294d929d53d4583333.jpg',
'https://i.pinimg.com/236x/63/94/55/639455b5afe5f4ac53a255bdb3b742f0.jpg',
'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRHgHXZtTJe7vhNFqo-rBAYMi-o9THfRv02Cg&s',
'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR5zIPiyLTekxARbGy5laICe-W-s2j814malN9GEuz-A_eLja-embDNqf0AsBH9f0xDAfc&usqp=CAU',
'https://modacombiscoitos.wordpress.com/wp-content/uploads/2012/08/croquis-de-yves-saint-laurent.jpg',
'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRXHQrq97yOpjK_hGv3y1td2BwKWNoiza4VHw&s',
'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTlVUlII92vRqytwAUz1P02FYF-laonJz_B9w&s',
'https://media.licdn.com/dms/image/v2/D4D12AQFShRlogPW3Kg/article-cover_image-shrink_600_2000/article-cover_image-shrink_600_2000/0/1733933674152?e=2147483647&v=beta&t=0mBfO3tWKpfPUyhXh4DV6FDijWKfmyRd3oys0HaQ9yQ',
'https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEgaCfxfMS2ANLtEd5O6LZIoPBeiw9P3ufFyDJjaLZRGxWDaVdxFX7RR77kCaGyCNlGIh3lGi3kngyKrx2p9UrAPpYwh-FrKAxWmahCcYotGuWixL_jravdrVCDkVaX_cuDsze_nSmo-8oI/s1600/barbiedesfile009.jpg',
'https://previews.123rf.com/images/manudesigns/manudesigns2207/manudesigns220700013/188795751-plus-size-fashion-figure-templates-exaggerated-croquis-for-fashion-design-and-illustration.jpg',
'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT4dNmu8I5-pnmQY1Kt9wuq8zMx9gESbMK7ag&s',
'https://capricho.abril.com.br/wp-content/uploads/2016/07/croquis-princesas-disney-elsa-cinderela57063.jpg?quality=70&strip=all',
'https://danidrops.com.br/wp-content/uploads/2023/01/05-Tendencia-de-Coque-2023.jpg',
'https://capricho.abril.com.br/wp-content/uploads/2016/08/croquis-moda-esmalte3.jpg?quality=70&strip=all',
'https://i.pinimg.com/736x/ca/77/55/ca77558e41b49d2a5049cdeae26f1a66.jpg',
'https://blog.damyller.com.br/wp-content/uploads/2025/08/Look-all-jeans-com-jaqueta-e-calca-1.webp',
'https://blog.damyller.com.br/wp-content/uploads/2025/08/Look-com-calca-jeans-e-jaqueta-marrom.webp',
'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSHVkDf1uI4BbaIR9GxxQFq78ncpUn3Yz_4CQ&s',
'https://i.pinimg.com/474x/85/20/f6/8520f6233508b18b066c1a1acabf4211.jpg',
'https://i.pinimg.com/originals/89/0e/67/890e675173afbfa9c3a4c09549d0b83d.jpg',
'https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEhN8KOKhAqqt1ZyJj1rNq518RDSF5QlTnSEPjGIYHgWzDiipJBQ0dbI6u9asdSeo9Kfqegn4CxtrFYNDOstLWmmAoK2BIzzr7WuToPErYdvJvIZ9JcfRkV6mTm078n11bfSrzKyFzqV9kQ/s280/FERNANDA+GUEDES+RED+SKETCHBOOK+FEV+3.jpg',
'https://market.sxediomodas.gr/wp-content/uploads/2024/02/My-Fashion-Models-430x430.jpg',
'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTWM4Ebmx0ew_bnHRfboXhfyTEEUjZTcZoCKg&s',
'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRJUW-JU9IfNUa4d93Ow7ZEEgleYQ-2YIAbVw&s',
'https://images.fineartamerica.com/images/artworkimages/mediumlarge/2/1-fashion-sketchbook-iv-anne-tavoletti.jpg',
'https://previews.123rf.com/images/vadymvdrobot/vadymvdrobot1706/vadymvdrobot170601761/80195379-young-female-professional-fashion-designer-holding-sketchbook-while-standing-at-her-studio.jpg',
'https://img.freepik.com/fotos-gratis/esboco-de-design-de-moda-de-estilo-de-arte-digital-em-papel_23-2151487038.jpg',
'https://i.pinimg.com/236x/01/b7/48/01b74899f170ce6b7cb711c570be9d4f.jpg',
'https://i.pinimg.com/236x/ba/df/58/badf58ec5c38b0703914bbc44937271e.jpg',
'https://img.freepik.com/fotos-gratis/esboco-de-design-de-moda-de-estilo-de-arte-digital-em-papel_23-2151487002.jpg?semt=ais_hybrid&w=740&q=80',

        ];

        foreach ($users as $userId) {
            foreach ($titles as $index => $title) {
                DB::table('sketchbooks')->insert([
                    'user_id' => $userId,
                    'title' => $title,
                    'description' => $descriptions[$index],
                    'image' => $images[$index],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}
?>
