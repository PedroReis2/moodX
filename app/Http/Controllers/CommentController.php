<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Guardar comentário via AJAX
    public function store(Request $request, $entryId)
    {
        $request->validate([
            'comentario' => 'required|string|max:1000',
        ]);

        $comment = Comment::create([
            'user_id' => auth()->id(),
            'sketchbook_entry_id' => $entryId,
            'comment' => $request->input('comentario'),
        ]);

        $comment->load('user.profile');

        return response()->json($comment);
    }

    // Atualizar utilizador com foto opcional
    public function addComment(Request $request)
    {
        $request->validate([
            'commentario' => 'required',
        ]);

        $photo = null;
        if ($request->hasFile('photo')) {
            $photo = Storage::putFile('uploadedImages', $request->photo);
        }

        User::where('id', $request->id)
            ->update([
                'name' => $request->name,
                'nif' => $request->nif,
                'address' => $request->address,
                'photo' => $photo,
            ]);

        return redirect()->route('all_user')->with('message', 'Actualizado com sucesso');
    }
}
