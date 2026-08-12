<?php

namespace App\Http\Controllers;

use App\Models\CreativeDna;
use App\Models\Moodboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MoodboardController extends Controller
{
    public const MIN_IMAGES = 4;
    public const MAX_IMAGES = 5;

    /**
     * Página do Moodboard (React).
     * Só é acessível depois de o utilizador ter carregado as imagens do Creative DNA.
     */
    public function index()
    {
        if (!CreativeDna::where('user_id', auth()->id())->exists()) {
            return redirect()->route('creative-dna');
        }

        return view('moodboard');
    }

    /**
     * Dados para a página: nome do utilizador e projetos.
     */
    public function data(Request $request)
    {
        $user = $request->user();

        $projects = Moodboard::where('user_id', $user->id)
            ->orderByDesc('id')
            ->get()
            ->map(fn (Moodboard $moodboard) => $this->serialize($moodboard));

        return response()->json([
            'user' => ['name' => $user->name],
            'projects' => $projects,
        ]);
    }

    /**
     * Criar um novo projeto (CRUD - Create).
     */
    public function store(Request $request)
    {
        $data = $this->validateProject($request);

        $moodboard = Moodboard::create([
            'user_id' => $request->user()->id,
            'title' => $data['title'],
            'images' => $data['paths'],
        ]);

        return response()->json([
            'message' => 'Project created.',
            'project' => $this->serialize($moodboard),
        ], 201);
    }

    /**
     * Atualizar um projeto existente (CRUD - Update).
     */
    public function update(Request $request, Moodboard $moodboard)
    {
        $this->authorizeOwner($request, $moodboard);
        $data = $this->validateProject($request, $moodboard);

        // Apagar imagens antigas que deixaram de ser usadas
        $removed = array_diff($moodboard->images ?? [], $data['paths']);
        foreach ($removed as $path) {
            Storage::disk('public')->delete($path);
        }

        $moodboard->update([
            'title' => $data['title'],
            'images' => $data['paths'],
        ]);

        return response()->json([
            'message' => 'Project updated.',
            'project' => $this->serialize($moodboard->fresh()),
        ]);
    }

    /**
     * Apagar um projeto (CRUD - Delete).
     */
    public function destroy(Request $request, Moodboard $moodboard)
    {
        $this->authorizeOwner($request, $moodboard);

        // Apagar as imagens do projeto
        foreach ($moodboard->images ?? [] as $path) {
            Storage::disk('public')->delete($path);
        }

        $moodboard->delete();

        return response()->json(['message' => 'Project deleted.']);
    }

    /**
     * Apagar todos os projetos do utilizador (CRUD - Delete All).
     */
    public function destroyAll(Request $request)
    {
        $user = $request->user();
        $projects = Moodboard::where('user_id', $user->id)->get();

        foreach ($projects as $project) {
            foreach ($project->images ?? [] as $path) {
                Storage::disk('public')->delete($path);
            }
        }

        Moodboard::where('user_id', $user->id)->delete();

        return response()->json(['message' => 'All projects deleted.']);
    }

    private function validateProject(Request $request, ?Moodboard $moodboard = null): array
    {
        $request->validate([
            'title' => ['required', 'string', 'max:100'],
            'files' => ['sometimes', 'array', 'max:' . self::MAX_IMAGES],
            'files.*' => ['image', 'max:5120'],
            'existing' => ['sometimes', 'array'],
            'existing.*' => ['string', 'max:255'],
        ]);

        $newFiles = $request->file('files') ?? [];
        $existing = $request->input('existing', []);
        $existing = is_array($existing) ? array_values(array_filter($existing)) : [];

        // Em criação não pode haver imagens "existentes"
        if ($moodboard === null) {
            abort_unless(count($existing) === 0, 422, 'You cannot reference existing images in a new project.');
        } else {
            $allowed = $moodboard->images ?? [];
            foreach ($existing as $path) {
                abort_unless(in_array($path, $allowed, true), 422, 'Invalid existing image.');
            }
        }

        $total = count($newFiles) + count($existing);
        abort_unless(
            $total >= self::MIN_IMAGES && $total <= self::MAX_IMAGES,
            422,
            sprintf('A project must contain between %d and %d images.', self::MIN_IMAGES, self::MAX_IMAGES)
        );

        $paths = $existing;
        foreach ($newFiles as $file) {
            $paths[] = $file->store('moodboards/' . $request->user()->id, 'public');
        }

        return [
            'title' => trim($request->input('title')),
            'paths' => $paths,
        ];
    }

    private function authorizeOwner(Request $request, Moodboard $moodboard): void
    {
        abort_unless($moodboard->user_id === $request->user()->id, 403);
    }

    private function serialize(Moodboard $moodboard): array
    {
        $paths = $moodboard->images ?? [];

        return [
            'id' => $moodboard->id,
            'title' => $moodboard->title,
            'images' => $paths,
            'imageUrls' => array_map(fn ($p) => asset('storage/' . $p), $paths),
            'coverUrl' => count($paths) ? asset('storage/' . $paths[0]) : null,
            'createdAt' => optional($moodboard->created_at)->toDateString(),
        ];
    }
}
