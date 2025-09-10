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
    'https://img.freepik.com/free-photo/modern-artist-concept-with-notebook-brush_1150-17340.jpg',
    'https://img.freepik.com/free-photo/essential-elements-for-fashion-design-in-studio_1150-17341.jpg',
    'https://img.freepik.com/free-photo/overhead-view-of-designers-hand-holding-fashion-sketch-over-workdesk_1150-17342.jpg',
    'https://img.freepik.com/free-photo/antique-dress-sketch-on-mannequin-exudes-elegance_1150-17343.jpg',
    'https://img.freepik.com/free-photo/psd-flat-lay-notebook-mock-up-and-pen-near-glasses-donut_1150-17344.jpg',
    'https://img.freepik.com/free-photo/hand-of-woman-drawing-painting-picture-with-oil-paints_1150-17345.jpg',
    'https://img.freepik.com/free-photo/elements-for-fashion-designing-in-studio_1150-17346.jpg',
    'https://img.freepik.com/free-photo/unique-style-sketchbook-with-portrayals-of-flapper-dresses-and-ties_1150-17347.jpg',
    'https://img.freepik.com/free-photo/psd-sketchbook-shows-dress-design-pencils-and-notes-transparent-image-of-sketchbook_1150-17348.jpg',
    'https://img.freepik.com/free-photo/fashion-designer-elements-and-drawings_1150-17349.jpg',
    'https://img.freepik.com/free-photo/fashion-designer-concept-flat-design-illustration_1150-17350.jpg',
    'https://img.freepik.com/free-photo/fashion-designer-flat-illustration_1150-17351.jpg',
    'https://img.freepik.com/free-photo/title-vignette-with-monogram_1150-17352.jpg',
    'https://img.freepik.com/free-photo/fashion-designer-illustration-with-essentials-on-table_1150-17353.jpg',
    'https://img.freepik.com/free-photo/handrawn-designer-desk_1150-17354.jpg',
    'https://img.freepik.com/free-photo/essential-elements-for-fashion-design-in-studio_1150-17355.jpg',
    'https://img.freepik.com/free-photo/hand-of-woman-drawing-painting-picture-with-oil-paints_1150-17356.jpg',
    'https://img.freepik.com/free-photo/elements-for-fashion-designing-in-studio_1150-17357.jpg',
    'https://img.freepik.com/free-photo/unique-style-sketchbook-with-portrayals-of-flapper-dresses-and-ties_1150-17358.jpg',
    'https://img.freepik.com/free-photo/psd-sketchbook-shows-dress-design-pencils-and-notes-transparent-image-of-sketchbook_1150-17359.jpg',
    'https://img.freepik.com/free-photo/fashion-designer-elements-and-drawings_1150-17360.jpg',
    'https://img.freepik.com/free-photo/fashion-designer-concept-flat-design-illustration_1150-17361.jpg',
    'https://img.freepik.com/free-photo/fashion-designer-flat-illustration_1150-17362.jpg',
    'https://img.freepik.com/free-photo/title-vignette-with-monogram_1150-17363.jpg',
    'https://img.freepik.com/free-photo/fashion-designer-illustration-with-essentials-on-table_1150-17364.jpg',
    'https://img.freepik.com/free-photo/handrawn-designer-desk_1150-17365.jpg',
    'https://img.freepik.com/free-photo/essential-elements-for-fashion-design-in-studio_1150-17366.jpg',
    'https://img.freepik.com/free-photo/hand-of-woman-drawing-painting-picture-with-oil-paints_1150-17367.jpg',
    'https://img.freepik.com/free-photo/elements-for-fashion-designing-in-studio_1150-17368.jpg',
    'https://img.freepik.com/free-photo/unique-style-sketchbook-with-portrayals-of-flapper-dresses-and-ties_1150-17369.jpg',
    'https://img.freepik.com/free-photo/psd-sketchbook-shows-dress-design-pencils-and-notes-transparent-image-of-sketchbook_1150-17370.jpg',
    'https://img.freepik.com/free-photo/fashion-designer-elements-and-drawings_1150-17371.jpg',
    'https://img.freepik.com/free-photo/fashion-designer-concept-flat-design-illustration_1150-17372.jpg',
    'https://img.freepik.com/free-photo/fashion-designer-flat-illustration_1150-17373.jpg',
    'https://img.freepik.com/free-photo/title-vignette-with-monogram_1150-17374.jpg',
    'https://img.freepik.com/free-photo/fashion-designer-illustration-with-essentials-on-table_1150-17375.jpg',
    'https://img.freepik.com/free-photo/handrawn-designer-desk_1150-17376.jpg',
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
