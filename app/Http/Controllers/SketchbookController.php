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
        // dd($sketchbookEntries);
        return view('dashboard.projects', compact('sketchbookEntries'));
    }

    // Mostra todas as entries de um sketchbook partilhado com o User
    public function sketchbookEntryShared($sketchbookId)
    {
        $sketchbookEntries = $this->getSharedEntries($sketchbookId);
        //dd($sketchbookEntries);
        return view('dashboard.projects', compact('sketchbookEntries'));
    }

    // Galeria com todos os sketchbooks do utilizador
    public function dashboard()
    {
        $sketchbooks = $this->getUserSketchbooks();
        $sketchbooksShared = $this->getSharedSketchbooks();


        if ($sketchbooks->isNotEmpty())
            return view('dashboard.dashboard', compact('sketchbooks', 'sketchbooksShared'));
        else
            return view('dashboard.empty');
    }

    // Galeria com todos os sketchbooks partilhados com o utilizador
    public function sketchbookGalleryShared()
    {
        $sketchbooks = $this->getSharedSketchbooks();
        //dd(auth()->id());
        //dd($sketchbooks);
        return view('dashboard.gallery', compact('sketchbooks'));
    }

    // ------------------- Métodos privados -------------------

    private function getSharedSketchbooks()
    {
        $userId = auth()->id();

        return \DB::table('sketchbooks')
        ->join('sketchbook_entries', 'sketchbooks.id', '=', 'sketchbook_entries.sketchbook_id')
        ->join('shared_contents', 'sketchbook_entries.id', '=', 'shared_contents.sketchbook_entry_id')
        ->whereJsonContains('shared_contents.user_ids', $userId)
        ->select('sketchbooks.*')
        ->distinct()
        ->get();
    }

    private function getUserSketchbooks()
    {
        return Sketchbook::where('user_id', auth()->id())->get();
    }

    private function getEntries($sketchbookId)
{
    return SketchbookEntry::with(['comments.user', 'sketchbook.user'])
                          ->where('sketchbook_id', $sketchbookId)
                          ->get();
}

private function getSharedEntries($sketchbookId)
{
    $userId = auth()->id();

    return SketchbookEntry::with(['comments.user', 'sketchbook.user'])
        ->where('sketchbook_id', $sketchbookId)
        ->whereHas('sharedContents', function ($query) use ($userId) {
            $query->whereJsonContains('user_ids', $userId);
        })
        ->get();
}
}
