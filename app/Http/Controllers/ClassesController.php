<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Project;
use App\Models\Role;
use Illuminate\Http\Request;

class ClassesController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->role_id !== Role::FORMADOR_ID) {
            return redirect()->route('projects.index');
        }

        return view('classes');
    }

    public function data(Request $request)
    {
        $teacher = $request->user();

        abort_unless($teacher->role_id === Role::FORMADOR_ID, 403);

        $turmas = $teacher->turmasComoFormador()
            ->with(['alunos.projects.feedbacks.formador'])
            ->orderBy('name')
            ->get()
            ->map(fn($turma) => [
                'id' => $turma->id,
                'name' => $turma->name,
                'code' => $turma->code,
                // Cada turma mostra os projetos dos alunos que pertencem a ela.
                'projects' => $turma->alunos
                    ->flatMap(fn($student) => $student->projects->map(
                        fn(Project $project) => $this->serializeProject($project, $student, $teacher->id)
                    ))
                    ->sortByDesc('id')
                    ->values()
                    ->all(),
            ]);

        return response()->json(['classes' => $turmas]);
    }

    public function storeFeedback(Request $request, Project $project)
    {
        $teacher = $request->user();

        abort_unless($teacher->role_id === Role::FORMADOR_ID, 403);

        $validated = $request->validate([
            'content' => ['required', 'string', 'max:4000'],
        ]);

        $project->load('user');

        abort_unless($this->teacherCanAccessProject($teacher, $project), 403);

        // Um professor mantém um feedback editável por projeto.
        $feedback = Feedback::updateOrCreate(
            [
                'formador_id' => $teacher->id,
                'feedbackable_type' => Project::class,
                'feedbackable_id' => $project->id,
            ],
            ['content' => trim($validated['content'])]
        );

        return response()->json([
            'message' => 'Feedback saved successfully.',
            'feedback' => $this->serializeFeedback($feedback->load('formador')),
        ]);
    }

    private function teacherCanAccessProject($teacher, Project $project): bool
    {
        $studentTurmaId = $project->user?->turma_id;

        if (!$studentTurmaId) {
            return false;
        }

        return $teacher->turmasComoFormador()
            ->where('turmas.id', $studentTurmaId)
            ->exists();
    }

    private function serializeProject(Project $project, $student, int $teacherId): array
    {
        $paths = $project->images ?? [];
        $feedbacks = $project->feedbacks
            ->sortByDesc('created_at')
            ->values();

        return [
            'id' => $project->id,
            'title' => $project->title,
            'student' => $student->name,
            'studentEmail' => $student->email,
            'date' => optional($project->created_at)->toDateString(),
            'imageCount' => count($paths),
            'coverUrl' => count($paths) ? asset('storage/' . $paths[0]) : null,
            'palette' => collect($project->palette ?? [])->pluck('hex')->all(),
            'feedbacks' => $feedbacks->map(fn($feedback) => $this->serializeFeedback($feedback))->all(),
            'teacherFeedback' => optional($feedbacks->firstWhere('formador_id', $teacherId))->content,
        ];
    }

    private function serializeFeedback(Feedback $feedback): array
    {
        return [
            'id' => $feedback->id,
            'content' => $feedback->content,
            'teacherName' => $feedback->formador->name ?? 'Teacher',
            'createdAt' => optional($feedback->created_at)->toDateString(),
        ];
    }
}
