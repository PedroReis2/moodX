<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SketchbookEntrySeeder extends Seeder
{
    public function run(): void
    {
$urls = [
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
    'https://img.freepik.com/free-photo/elements-for-fashion-designing-in-studio_1150-17412.jpg',
    'https://img.freepik.com/free-photo/fashion-designer-elements-and-drawings_1150-17413.jpg',
    'https://img.freepik.com/free-photo/fashion-designer-concept-flat-design-illustration_1150-17414.jpg',
    'https://img.freepik.com/free-photo/fashion-designer-flat-illustration_1150-17415.jpg',
    'https://img.freepik.com/free-photo/title-vignette-with-monogram_1150-17416.jpg',
    'https://img.freepik.com/free-photo/fashion-designer-illustration-with-essentials-on-table_1150-17417.jpg',
    'https://img.freepik.com/free-photo/handrawn-designer-desk_1150-17418.jpg',
    'https://img.freepik.com/free-photo/essential-elements-for-fashion-design-in-studio_1150-17419.jpg',
    'https://img.freepik.com/free-photo/hand-of-woman-drawing-painting-picture-with-oil-paints_1150-17420.jpg',
    'https://img.freepik.com/free-photo/elements-for-fashion-designing-in-studio_1150-17421.jpg',
    'https://img.freepik.com/free-photo/unique-style-sketchbook-with-portrayals-of-flapper-dresses-and-ties_1150-17422.jpg',
    'https://img.freepik.com/free-photo/psd-sketchbook-shows-dress-design-pencils-and-notes-transparent-image-of-sketchbook_1150-17423.jpg',
    'https://img.freepik.com/free-photo/fashion-designer-elements-and-drawings_1150-17424.jpg',
    'https://img.freepik.com/free-photo/fashion-designer-concept-flat-design-illustration_1150-17425.jpg',
    'https://img.freepik.com/free-photo/fashion-designer-flat-illustration_1150-17426.jpg',
    'https://img.freepik.com/free-photo/title-vignette-with-monogram_1150-17427.jpg',
    'https://img.freepik.com/free-photo/fashion-designer-illustration-with-essentials-on-table_1150-17428.jpg',
    'https://img.freepik.com/free-photo/handrawn-designer-desk_1150-17429.jpg',
    'https://img.freepik.com/free-photo/essential-elements-for-fashion-design-in-studio_1150-17430.jpg',
    'https://img.freepik.com/free-photo/hand-of-woman-drawing-painting-picture-with-oil-paints_1150-17431.jpg',
    'https://img.freepik.com/free-photo/elements-for-fashion-designing-in-studio_1150-17432.jpg',
    'https://img.freepik.com/free-photo/unique-style-sketchbook-with-portrayals-of-flapper-dresses-and-ties_1150-17433.jpg',
    'https://img.freepik.com/free-photo/psd-sketchbook-shows-dress-design-pencils-and-notes-transparent-image-of-sketchbook_1150-17434.jpg',
    'https://img.freepik.com/free-photo/fashion-designer-elements-and-drawings_1150-17435.jpg',
    'https://img.freepik.com/free-photo/fashion-designer-concept-flat-design-illustration_1150-17436.jpg',
    'https://img.freepik.com/free-photo/fashion-designer-flat-illustration_1150-17437.jpg',
    'https://img.freepik.com/free-photo/title-vignette-with-monogram_1150-17438.jpg',
    'https://img.freepik.com/free-photo/fashion-designer-illustration-with-essentials-on-table_1150-17439.jpg',
    'https://img.freepik.com/free-photo/handrawn-designer-desk_1150-17440.jpg',
    'https://img.freepik.com/free-photo/essential-elements-for-fashion-design-in-studio_1150-17441.jpg',
    'https://img.freepik.com/free-photo/hand-of-woman-drawing-painting-picture-with-oil-paints_1150-17442.jpg',
    'https://img.freepik.com/free-photo/elements-for-fashion-designing-in-studio_1150-17443.jpg',
    'https://img.freepik.com/free-photo/unique-style-sketchbook-with-portrayals-of-flapper-dresses-and-ties_1150-17444.jpg',
    'https://img.freepik.com/free-photo/psd-sketchbook-shows-dress-design-pencils-and-notes-transparent-image-of-sketchbook_1150-17445.jpg',
    'https://img.freepik.com/free-photo/fashion-designer-elements-and-drawings_1150-17446.jpg',
    'https://img.freepik.com/free-photo/fashion-designer-concept-flat-design-illustration_1150-17447.jpg',
    'https://img.freepik.com/free-photo/fashion-designer-flat-illustration_1150-17448.jpg',
    'https://img.freepik.com/free-photo/title-vignette-with-monogram_1150-17449.jpg',
    'https://img.freepik.com/free-photo/fashion-designer-illustration-with-essentials-on-table_1150-17450.jpg',
    'https://img.freepik.com/free-photo/handrawn-designer-desk_1150-17451.jpg',
    'https://img.freepik.com/free-photo/essential-elements-for-fashion-design-in-studio_1150-17452.jpg'
        ];

        $entries = [];
        $totalUrls = count($urls);

        for ($sketchbookId = 1; $sketchbookId <= 60; $sketchbookId++) {
            for ($i = 1; $i <= 3; $i++) {
                $urlIndex = ($sketchbookId * $i - 1) % $totalUrls; // garante que index não ultrapassa o total de URLs
                $entries[] = [
                    'sketchbook_id' => $sketchbookId,
                    'content_type' => 'image',
                    'content_url' => $urls[$urlIndex],
                    'content_text' => "Entry {$i} do sketchbook {$sketchbookId}.",
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
        }

        DB::table('sketchbook_entries')->insert($entries);
    }
}
