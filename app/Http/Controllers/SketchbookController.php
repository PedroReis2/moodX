<?php

namespace App\Http\Controllers;

use App\Models\Sketchbook;
use App\Models\SketchbookEntry;
use App\Models\Comment;
use Illuminate\Http\Request;

class SketchbookController extends Controller
{
    // Mostra todas as entries de um sketchbook
    public function sketchbookEntry($sketchbookId)
    {
        $sketchbookEntries = $this->getEntries($sketchbookId);

        return view('sketchbook.sketchbook-entries', compact('sketchbookEntries'));
    }
    
    // Galeria com todos os sketchbooks do utilizador
    public function sketchbookGallery()
    {
        $sketchbooks = $this->getUserSketchbooks();

        return view('sketchbook.sketchbook-gallery', compact('sketchbooks'));
    }

    // ------------------- Métodos privados -------------------

    private function getUserSketchbooks()
    {
        return Sketchbook::where('user_id', auth()->id())->get();
    }

    private function getEntries($sketchbookId)
    {
        return SketchbookEntry::with(['comments.user'])
                          ->where('sketchbook_id', $sketchbookId)
                          ->get();
    }

    private function getComments($sketchbookId)
    {
        return Comment::where('sketchbook_entry_id', $sketchbookId)
                      ->get();
    }
}
