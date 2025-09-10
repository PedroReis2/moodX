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
                'https://img.freepik.com/free-photo/essential-elements-for-fashion-design-in-studio_1150-17377.jpg',
                'https://img.freepik.com/free-photo/hand-of-woman-drawing-painting-picture-with-oil-paints_1150-17378.jpg',
                'https://img.freepik.com/free-photo/elements-for-fashion-designing-in-studio_1150-17379.jpg',
                'https://img.freepik.com/free-photo/unique-style-sketchbook-with-portrayals-of-flapper-dresses-and-ties_1150-17380.jpg',
                'https://img.freepik.com/free-photo/psd-sketchbook-shows-dress-design-pencils-and-notes-transparent-image-of-sketchbook_1150-17381.jpg',
                'https://img.freepik.com/free-photo/fashion-designer-elements-and-drawings_1150-17382.jpg',
                'https://img.freepik.com/free-photo/fashion-designer-concept-flat-design-illustration_1150-17383.jpg',
                'https://img.freepik.com/free-photo/fashion-designer-flat-illustration_1150-17384.jpg',
                'https://img.freepik.com/free-photo/title-vignette-with-monogram_1150-17385.jpg',
                'https://img.freepik.com/free-photo/fashion-designer-illustration-with-essentials-on-table_1150-17386.jpg',
                'https://img.freepik.com/free-photo/handrawn-designer-desk_1150-17387.jpg',
                'https://img.freepik.com/free-photo/essential-elements-for-fashion-design-in-studio_1150-17388.jpg',
                'https://img.freepik.com/free-photo/hand-of-woman-drawing-painting-picture-with-oil-paints_1150-17389.jpg',
                'https://img.freepik.com/free-photo/elements-for-fashion-designing-in-studio_1150-17390.jpg',
                'https://img.freepik.com/free-photo/unique-style-sketchbook-with-portrayals-of-flapper-dresses-and-ties_1150-17391.jpg',
                'https://img.freepik.com/free-photo/psd-sketchbook-shows-dress-design-pencils-and-notes-transparent-image-of-sketchbook_1150-17392.jpg',
                'https://img.freepik.com/free-photo/fashion-designer-elements-and-drawings_1150-17393.jpg',
                'https://img.freepik.com/free-photo/fashion-designer-concept-flat-design-illustration_1150-17394.jpg',
                'https://img.freepik.com/free-photo/fashion-designer-flat-illustration_1150-17395.jpg',
                'https://img.freepik.com/free-photo/title-vignette-with-monogram_1150-17396.jpg',
                'https://img.freepik.com/free-photo/fashion-designer-illustration-with-essentials-on-table_1150-17397.jpg',
                'https://img.freepik.com/free-photo/handrawn-designer-desk_1150-17398.jpg',
                'https://img.freepik.com/free-photo/essential-elements-for-fashion-design-in-studio_1150-17399.jpg',
                'https://img.freepik.com/free-photo/hand-of-woman-drawing-painting-picture-with-oil-paints_1150-17400.jpg',
                'https://img.freepik.com/free-photo/elements-for-fashion-designing-in-studio_1150-17401.jpg',
                'https://img.freepik.com/free-photo/unique-style-sketchbook-with-portrayals-of-flapper-dresses-and-ties_1150-17402.jpg',
                'https://img.freepik.com/free-photo/psd-sketchbook-shows-dress-design-pencils-and-notes-transparent-image-of-sketchbook_1150-17403.jpg',
                'https://img.freepik.com/free-photo/fashion-designer-elements-and-drawings_1150-17404.jpg',
                'https://img.freepik.com/free-photo/fashion-designer-concept-flat-design-illustration_1150-17405.jpg',
                'https://img.freepik.com/free-photo/fashion-designer-flat-illustration_1150-17406.jpg',
                'https://img.freepik.com/free-photo/title-vignette-with-monogram_1150-17407.jpg',
                'https://img.freepik.com/free-photo/fashion-designer-illustration-with-essentials-on-table_1150-17408.jpg',
                'https://img.freepik.com/free-photo/handrawn-designer-desk_1150-17409.jpg',
                'https://img.freepik.com/free-photo/essential-elements-for-fashion-design-in-studio_1150-17410.jpg',
                'https://img.freepik.com/free-photo/hand-of-woman-drawing-painting-picture-with-oil-paints_1150-17411.jpg',
                'https://img.freepik.com/free-photo/elements-for-fashion-designing-in-studio_1150-17412.jpg'
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
