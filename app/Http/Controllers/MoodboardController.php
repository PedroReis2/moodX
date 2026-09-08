<?php

namespace App\Http\Controllers;

use App\Models\CreativeDna;
use App\Models\Moodboard;
use App\Models\MoodboardLike;
use App\Models\Project;
use App\Services\ColorPaletteService;
use Illuminate\Http\Request;

class MoodboardController extends Controller
{
    public const MIN_PROJECTS = 1;
    public const MAX_PROJECTS = 5;
    private const DNA_IMAGES_LIMIT = 5;
    private const PROJECT_IMAGES_LIMIT = 20;
    private const IMAGES_PER_PROJECT_IF_FEW = 5;

    public function index()
    {
        return view('moodboard-select');
    }

    public function myMoodboards()
    {
        return view('my-moodboards');
    }

    public function gallery()
    {
        return view('gallery');
    }

    public function selectData(Request $request)
    {
        $projects = Project::where('user_id', $request->user()->id)
            ->orderByDesc('id')
            ->get()
            ->map(fn(Project $project) => [
                'id' => $project->id,
                'title' => $project->title,
                'coverUrl' => count($project->images ?? [])
                    ? asset('storage/' . $project->images[0])
                    : null,
            ]);

        return response()->json(['projects' => $projects]);
    }

    public function data(Request $request)
    {
        $moodboards = Moodboard::with(['projects', 'paletteColors', 'likes'])
            ->where('user_id', $request->user()->id)
            ->orderByDesc('id')
            ->get()
            ->map(fn(Moodboard $m) => $this->serialize($m, $request->user()->id, includeAuthor: false));

        return response()->json(['moodboards' => $moodboards]);
    }

    public function galleryData(Request $request)
    {
        $moodboards = Moodboard::with(['user', 'projects', 'paletteColors', 'likes'])
            ->where('is_public', true)
            ->orderByDesc('id')
            ->get()
            ->map(fn(Moodboard $m) => $this->serialize($m, $request->user()->id, includeAuthor: true));

        return response()->json(['moodboards' => $moodboards]);
    }

    public function store(Request $request, ColorPaletteService $palettes)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:2000'],
            'project_ids' => ['required', 'array', 'min:' . self::MIN_PROJECTS, 'max:' . self::MAX_PROJECTS],
            'project_ids.*' => ['integer'],
            'is_public' => ['sometimes', 'boolean'],
        ]);

        $user = $request->user();

        $projects = Project::where('user_id', $user->id)
            ->whereIn('id', $request->input('project_ids'))
            ->get();

        abort_unless(
            $projects->count() === count($request->input('project_ids')),
            422,
            'One or more selected projects are invalid.'
        );

        $projectColors = $projects
            ->flatMap(fn(Project $project) => $project->image_colors ?? [])
            ->flatMap(fn($item) => $item['colors'] ?? [])
            ->values()
            ->all();

        // Sorteia até 5 imagens do Creative DNA — a seleção fica fixa
        // a partir daqui, guardada em dna_image_ids.
        $selectedDna = $this->pickRandomDnaImages($user->id);

        $dnaColors = $selectedDna
            ->flatMap(fn($file) => $file->colors ?? [])
            ->values()
            ->all();

        // Sorteia as imagens de projeto para a collage (máx. 20, sem
        // duplicados) — a seleção fica fixa, guardada em project_image_paths.
        $selectedProjectPaths = $this->pickProjectImagePaths($projects);

        // 30% Creative DNA + 70% projetos combinados.
        $finalPalette = $palettes->buildFinalPalette($dnaColors, $projectColors, 10);

        $moodboard = Moodboard::create([
            'user_id' => $user->id,
            'title' => trim($request->input('title')),
            'description' => $request->filled('description') ? trim($request->input('description')) : null,
            'is_public' => $request->boolean('is_public', false),
            'dna_image_ids' => $selectedDna->pluck('id')->all(),
            'project_image_paths' => $selectedProjectPaths,
        ]);

        $moodboard->projects()->attach($projects->pluck('id'));

        foreach (array_values($finalPalette) as $position => $color) {
            $source = in_array('project', $color['sources'], true) ? 'project' : 'dna';

            $moodboard->paletteColors()->create([
                'hex_color' => $color['hex'],
                'source' => $source,
                'position' => $position,
            ]);
        }

        $moodboard->load(['projects', 'paletteColors', 'likes']);

        return response()->json([
            'message' => 'Moodboard created.',
            'moodboard' => $this->serialize($moodboard, $user->id, includeAuthor: false),
        ], 201);
    }

    public function togglePublic(Request $request, Moodboard $moodboard)
    {
        abort_unless($moodboard->user_id === $request->user()->id, 403);

        $moodboard->update(['is_public' => !$moodboard->is_public]);
        $moodboard->load(['projects', 'paletteColors', 'likes']);

        return response()->json([
            'message' => 'Visibility updated.',
            'moodboard' => $this->serialize($moodboard, $request->user()->id, includeAuthor: false),
        ]);
    }

    public function toggleLike(Request $request, Moodboard $moodboard)
    {
        abort_unless(
            $moodboard->is_public || $moodboard->user_id === $request->user()->id,
            403
        );

        $existing = MoodboardLike::where('moodboard_id', $moodboard->id)
            ->where('user_id', $request->user()->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $liked = false;
        } else {
            MoodboardLike::create([
                'moodboard_id' => $moodboard->id,
                'user_id' => $request->user()->id,
            ]);
            $liked = true;
        }

        return response()->json([
            'liked' => $liked,
            'likesCount' => $moodboard->likes()->count(),
        ]);
    }

    public function destroy(Request $request, Moodboard $moodboard)
    {
        abort_unless($moodboard->user_id === $request->user()->id, 403);

        $moodboard->delete();

        return response()->json(['message' => 'Moodboard deleted.']);
    }

    /**
     * Sorteia aleatoriamente até 5 imagens do Creative DNA do utilizador.
     * Usado apenas no momento de criar o moodboard — a seleção fica fixa
     * a partir daí, guardada em dna_image_ids.
     */
    private function pickRandomDnaImages(int $userId)
    {
        $all = CreativeDna::where('user_id', $userId)->get();

        return $all->random(min(self::DNA_IMAGES_LIMIT, $all->count()));
    }

    /**
     * Escolhe os paths de imagem dos projetos selecionados para a collage:
     * - Se poucos projetos (1 a 3), mostra todas as imagens de cada um
     *   (até 5 por projeto), sem sorteio.
     * - Se o total ultrapassar 20, sorteia 20 aleatoriamente sem duplicados
     *   a partir do conjunto combinado de todos os projetos selecionados.
     */
    private function pickProjectImagePaths($projects): array
    {
        $allPaths = $projects
            ->flatMap(fn(Project $project) => array_slice($project->images ?? [], 0, self::IMAGES_PER_PROJECT_IF_FEW))
            ->unique()
            ->values();

        if ($allPaths->count() <= self::PROJECT_IMAGES_LIMIT) {
            return $allPaths->all();
        }

        return $allPaths->random(self::PROJECT_IMAGES_LIMIT)->values()->all();
    }

    /**
     * Devolve as imagens do Creative DNA associadas a um moodboard já
     * criado, usando os IDs fixos guardados em dna_image_ids — garante
     * que a collage mostra sempre as mesmas imagens entre visitas.
     */
    private function getMoodboardDnaImages(Moodboard $moodboard)
    {
        $ids = $moodboard->dna_image_ids ?? [];

        if (empty($ids)) {
            return collect();
        }

        return CreativeDna::whereIn('id', $ids)->get();
    }

    private function serialize(Moodboard $moodboard, int $currentUserId, bool $includeAuthor): array
    {
        $dnaImages = $this->getMoodboardDnaImages($moodboard)
            ->map(fn($item) => asset('storage/' . $item->path));

        $projects = $moodboard->projects;

        // Usa os paths fixos guardados na criação; se for um moodboard
        // antigo sem essa seleção guardada, cai para todas as imagens
        // dos projetos selecionados, sem duplicados.
        $projectPaths = $moodboard->project_image_paths
            ?? $projects->flatMap(fn(Project $project) => $project->images ?? [])->all();

        $projectImages = collect($projectPaths)->map(fn($path) => asset('storage/' . $path));

        $images = $dnaImages->merge($projectImages)->values()->all();

        $palette = $moodboard->paletteColors->map(fn($c) => [
            'hex' => $c->hex_color,
            'source' => $c->source,
        ])->values()->all();

        $payload = [
            'id' => $moodboard->id,
            'title' => $moodboard->title,
            'description' => $moodboard->description,
            'projectTitles' => $projects->pluck('title')->all(),
            'images' => $images,
            'palette' => $palette,
            'isPublic' => $moodboard->is_public,
            'likesCount' => $moodboard->likes->count(),
            'likedByUser' => $moodboard->likes->contains('user_id', $currentUserId),
            'createdAt' => optional($moodboard->created_at)->toDateString(),
        ];

        if ($includeAuthor) {
            $payload['authorName'] = $moodboard->user->name ?? 'Unknown';
        }

        return $payload;
    }
}