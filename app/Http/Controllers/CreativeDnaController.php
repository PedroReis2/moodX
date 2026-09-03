<?php

namespace App\Http\Controllers;

use App\Models\CreativeDna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\ColorPaletteService;

class CreativeDnaController extends Controller
{
    /**
     * Página de visualização (só leitura) das imagens do Creative DNA do utilizador.
     */
    public function gallery()
    {
        // Sem Creative DNA não há imagens para mostrar — volta para Projects.
        if (!CreativeDna::where('user_id', auth()->id())->exists()) {
            return redirect()->route('projects.index');
        }

        return view('creative-dna-gallery');
    }

    /**
     * Devolve os URLs públicos das imagens do Creative DNA do utilizador autenticado.
     */
    public function images(Request $request)
    {
        $rows = CreativeDna::where('user_id', $request->user()->id)
            ->orderBy('id')
            ->get(['path', 'original_name']);

        return response()->json([
            'images' => $rows->map(fn ($row) => [
                'url' => asset('storage/' . $row->path),
                'name' => $row->original_name,
            ])->values(),
        ]);
    }

    /**
     * Guarda os ficheiros de imagem enviados pelo utilizador.
     * Exige no mínimo 20 ficheiros de imagem.
     * Em re-upload, substitui as imagens anteriores do utilizador.
     */
    public function upload(Request $request, ColorPaletteService $palettes)
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
                // Extrair e guardar as cores principais desta imagem do Creative DNA.
                'colors' => $palettes->extractFromPublicPath($path),

            ]);

            $saved++;
        }

        return response()->json([
            'message' => 'Upload successful.',
            'saved' => $saved,
        ]);
    }
}
