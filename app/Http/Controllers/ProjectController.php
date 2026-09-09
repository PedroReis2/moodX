<?php

namespace App\Http\Controllers;

use App\Models\CreativeDna;
use App\Models\Project;
use App\Services\ColorPaletteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public const MIN_IMAGES = 4;
    public const MAX_IMAGES = 5;

    /**
     * Página de Projects (React).
     * Só é acessível depois de o utilizador ter carregado as imagens do Creative DNA.
     */
    public function index()
    {
        if (!CreativeDna::where('user_id', auth()->id())->exists()) {
            return redirect()->route('creative-dna');
        }

        return view('projects');
    }

    /**
     * Dados para a página: nome do utilizador e projetos.
     */
    public function data(Request $request)
    {
        $user = $request->user();

        $projects = Project::where('user_id', $user->id)
            ->with('feedbacks.formador')
            ->orderByDesc('id')
            ->get()
            ->map(fn(Project $project) => $this->serialize($project));

        return response()->json([
            'user' => ['name' => $user->name],
            'projects' => $projects,
        ]);
    }

    /**
     * Criar um novo projeto (CRUD - Create).
     */
    public function store(Request $request, ColorPaletteService $palettes)
    {
        $data = $this->validateProject($request);

        // Extrair as cores das imagens escolhidas para este projeto.
        $imageColors = $this->extractProjectColors($data['paths'], $palettes);

        // Gerar a paleta final: 30% Creative DNA + 70% projeto.
        $finalPalette = $palettes->buildFinalPalette(
            $this->getCreativeDnaColors($request->user()->id),
            collect($imageColors)->flatMap(fn($item) => $item['colors'])->values()->all()
        );

        $project = Project::create([
            'user_id' => $request->user()->id,
            'title' => $data['title'],
            'images' => $data['paths'],
            'image_colors' => $imageColors,
            'palette' => $finalPalette,
        ]);

        return response()->json([
            'message' => 'Project created.',
            'project' => $this->serialize($project),
        ], 201);
    }

    /**
     * Atualizar um projeto existente (CRUD - Update).
     */
    public function update(Request $request, Project $project, ColorPaletteService $palettes)
    {
        $this->authorizeOwner($request, $project);
        $data = $this->validateProject($request, $project);

        // Apagar imagens antigas que deixaram de ser usadas
        $removed = array_diff($project->images ?? [], $data['paths']);
        foreach ($removed as $path) {
            Storage::disk('public')->delete($path);
        }
        // Recalcular as cores sempre que o projeto é atualizado.
        $imageColors = $this->extractProjectColors($data['paths'], $palettes);

        // Recriar a paleta final com o peso definido: 30% DNA e 70% projeto.
        $finalPalette = $palettes->buildFinalPalette(
            $this->getCreativeDnaColors($request->user()->id),
            collect($imageColors)->flatMap(fn($item) => $item['colors'])->values()->all()
        );

        $project->update([
            'title' => $data['title'],
            'images' => $data['paths'],
            'image_colors' => $imageColors,
            'palette' => $finalPalette,
        ]);

        return response()->json([
            'message' => 'Project updated.',
            'project' => $this->serialize($project->fresh()),
        ]);
    }

    /**
     * Apagar um projeto (CRUD - Delete).
     */
    public function destroy(Request $request, Project $project)
    {
        $this->authorizeOwner($request, $project);

        // Apagar as imagens do projeto
        foreach ($project->images ?? [] as $path) {
            Storage::disk('public')->delete($path);
        }

        $project->delete();

        return response()->json(['message' => 'Project deleted.']);
    }

    /**
     * Apagar todos os projetos do utilizador (CRUD - Delete All).
     */
    public function destroyAll(Request $request)
    {
        $user = $request->user();
        $projects = Project::where('user_id', $user->id)->get();

        foreach ($projects as $project) {
            foreach ($project->images ?? [] as $path) {
                Storage::disk('public')->delete($path);
            }
        }

        Project::where('user_id', $user->id)->delete();

        return response()->json(['message' => 'All projects deleted.']);
    }

    private function validateProject(Request $request, ?Project $project = null): array
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
        if ($project === null) {
            abort_unless(count($existing) === 0, 422, 'You cannot reference existing images in a new project.');
        } else {
            $allowed = $project->images ?? [];
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
            $paths[] = $file->store('projects/' . $request->user()->id, 'public');
        }

        return [
            'title' => trim($request->input('title')),
            'paths' => $paths,
        ];
    }
    private function extractProjectColors(array $paths, ColorPaletteService $palettes): array
    {
        return array_map(fn($path) => [
            'path' => $path,
            // Guardar as cores por imagem para conseguir consultar ou recalcular depois,
            // usando crop de 60% central para reduzir o peso do fundo neutro.
            'colors' => $palettes->extractFromPublicPath($path, 6, 0.6),
        ], $paths);
    }

    private function getCreativeDnaColors(int $userId): array
    {
        return CreativeDna::where('user_id', $userId)
            ->get()
            ->flatMap(fn($file) => $file->colors ?? [])
            ->values()
            ->all();
    }

    private function authorizeOwner(Request $request, Project $project): void
    {
        abort_unless($project->user_id === $request->user()->id, 403);
    }

    private function serialize(Project $project): array
    {
        $project->loadMissing('feedbacks.formador');

        $paths = $project->images ?? [];

        return [
            'id' => $project->id,
            'title' => $project->title,
            'images' => $paths,
            'imageUrls' => array_map(fn($p) => asset('storage/' . $p), $paths),
            'coverUrl' => count($paths) ? asset('storage/' . $paths[0]) : null,
            'createdAt' => optional($project->created_at)->toDateString(),
            'imageColors' => $project->image_colors ?? [],
            'palette' => $project->palette ?? [],
            'feedbacks' => $project->feedbacks->map(fn($feedback) => [
                'id' => $feedback->id,
                'content' => $feedback->content,
                'teacherName' => $feedback->formador->name ?? 'Teacher',
                'createdAt' => optional($feedback->created_at)->toDateString(),
            ])->values()->all(),
        ];
    }
}
