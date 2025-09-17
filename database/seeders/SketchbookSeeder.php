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
'data:image/jpeg;base64,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',
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
