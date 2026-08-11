<?php

namespace App\Http\Controllers;

use App\Models\CreativeDna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CreativeDnaController extends Controller
{
    /**
     * Guarda os ficheiros de imagem enviados pelo utilizador.
     * Exige no mínimo 20 ficheiros de imagem.
     * Em re-upload, substitui as imagens anteriores do utilizador.
     */
    public function upload(Request $request)
    {
        $request->validate([
            'files' => ['required', 'array', 'min:20', 'max:30'],
            'files.*' => ['image', 'max:5120'],
        ]);

        $user = $request->user();

        // Re-upload: apaga as imagens anteriores do Creative DNA do utilizador
        $previous = CreativeDna::where('user_id', $user->id)->get();
        foreach ($previous as $row) {
            Storage::disk('public')->delete($row->path);
        }
        CreativeDna::where('user_id', $user->id)->delete();

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
