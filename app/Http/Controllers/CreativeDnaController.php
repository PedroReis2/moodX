<?php

namespace App\Http\Controllers;

use App\Models\CreativeDna;
use Illuminate\Http\Request;

class CreativeDnaController extends Controller
{
    /**
     * Guarda os ficheiros de imagem enviados pelo utilizador.
     * Exige no mínimo 20 ficheiros de imagem.
     */
    public function upload(Request $request)
    {
        $request->validate([
            'files' => ['required', 'array', 'min:20', 'max:30'],
            'files.*' => ['image', 'max:5120'],
        ]);

        $user = $request->user();
        $saved = 0;

        foreach ($request->file('files') as $file) {
            $path = $file->store('creative-dna/' . $user->id, 'public');

            CreativeDna::create([
                'user_id' => $user->id,
                'original_name' => $file->getClientOriginalName(),
                'path' => $path,
            ]);

            $saved++;
        }

        return response()->json([
            'message' => 'Upload successful.',
            'saved' => $saved,
        ]);
    }
}
