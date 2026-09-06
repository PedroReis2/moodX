<?php

namespace App\Http\Controllers;

use App\Models\CreativeDna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\ColorPaletteService;

class CreativeDnaController extends Controller
{
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
                // Extrair e guardar as cores principais desta imagem do Creative DNA,
                // usando um crop de 60% central para reduzir o peso do fundo
                // neutro típico das fotos de moda.
                'colors' => $palettes->extractFromPublicPath($path, 6, 0.6),

            ]);

            $saved++;
        }

        return response()->json([
            'message' => 'Upload successful.',
            'saved' => $saved,
        ]);
    }

    // devolve os dados do creative dna do utilizador logado, incluindo as cores extraídas de cada imagem para mostrarem numa view (pagina)
    public function data(Request $request, ColorPaletteService $palettes)
    {
        $items = CreativeDna::where('user_id', $request->user()->id)->get();

        $allColors = $items->flatMap(fn($item) => $item->colors ?? [])->all();

        return response()->json([
            'exists' => $items->isNotEmpty(),
            'images' => $items->map(fn($item) => [
                'id' => $item->id,
                'url' => asset('storage/' . $item->path),
            ]),
            'palette' => $palettes->buildFinalPalette($allColors, [], 8),
        ]);
    }

    /**
     * Apaga o Creative DNA do utilizador (registo e ficheiros de imagem).
     * Utilizado pelo botão "Delete" na página de visualização do Creative DNA.
     */
    public function destroy(Request $request)
    {
        $rows = CreativeDna::where('user_id', $request->user()->id)->get();

        foreach ($rows as $row) {
            Storage::disk('public')->delete($row->path);
        }
        CreativeDna::where('user_id', $request->user()->id)->delete();

        return response()->json(['message' => 'Creative DNA deleted.']);
    }
}
