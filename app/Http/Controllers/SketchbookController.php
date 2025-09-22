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
        $sketchbookEntries = $this->getSharedEntries($sketchbookId);
        // dd($sketchbookEntries);
        return view('dashboard.projects', compact('sketchbookEntries'));
    }




    //Mostra todas as entries de um sketchbook partilhado com o User
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
        $sketchbooksShared = $this->getSharedSketchbooksbyUser();


        if ($sketchbooks->isNotEmpty())
            return view('dashboard.dashboard', compact('sketchbooks', 'sketchbooksShared'));
        else
            return view('dashboard.empty');
    }




    // Galeria com todos os sketchbooks partilhados com o formador
    public function dashboardTeacher()
    {
        $sketchbooksShared = $this->getSharedSketchbooksbyUser();
        //dd($sketchbooksShared);
        return view('dashboard.dashboard-teacher', compact('sketchbooksShared'));
    }




    // Galeria com todos os sketchbooks partilhados com o utilizador
    public function sketchbookGalleryShared()
    {
        $sketchbooks = $this->getSharedSketchbooksbyUser();
        //dd(auth()->id());
        //dd($sketchbooks);
        return view('dashboard.gallery', compact('sketchbooks'));
    }











    // ------------------- Métodos privados -------------------


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


private function getSharedSketchbooksbyUser()
{
    $userId = auth()->id();

    $sketchbooks = Sketchbook::whereHas('entries.sharedContents', function ($query) use ($userId) {
        $query->whereJsonContains('user_ids', $userId);
    })->with(['entries.sharedContents', 'user'])->get();

    // Agrupa pelos DONOS dos sketchbooks, não pelos users partilhados
    return $sketchbooks->groupBy('user.name');
}


}
