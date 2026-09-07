<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Turma;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    // Mostra a página principal do dashboard admin.
    public function index()
    {
        return view('admin.dashboard');
    }

    // Envia para o React todos os dados necessários do admin.
    public function data()
    {
        return response()->json([
            // Roles disponíveis: admin, formador e aluno.
            'roles' => Role::orderBy('id')->get(),

            // Turmas com os alunos e formadores associados.
            'turmas' => Turma::with(['alunos', 'formadores'])
                ->orderBy('name')
                ->get(),

            // Lista de formadores com as turmas que acompanham.
            'formadores' => User::with('turmasComoFormador')
                ->where('role_id', Role::FORMADOR_ID)
                ->orderBy('name')
                ->get(),

            // Lista de alunos que já foram colocados numa turma.
            'alunos' => User::with('turma')
                ->where('role_id', Role::ALUNO_ID)
                ->whereNotNull('turma_id')
                ->orderBy('name')
                ->get(),

            // Pessoas novas que ainda precisam de ser classificadas pelo admin.
            'newUsers' => User::with(['turma', 'turmasComoFormador'])
                ->where('role_id', Role::ALUNO_ID)
                ->whereNull('turma_id')
                ->orderBy('created_at', 'desc')
                ->get(),
        ]);
    }

    // Atualiza o role de um utilizador e, se for aluno, a turma dele.
    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'role_id' => ['required', 'exists:roles,id'],
            'turma_id' => ['nullable', 'exists:turmas,id'],
        ]);

        $user->role_id = $validated['role_id'];

        // Só alunos ficam diretamente ligados a uma turma.
        if ((int) $validated['role_id'] === Role::ALUNO_ID) {
            $user->turma_id = $validated['turma_id'] ?? null;
        } else {
            $user->turma_id = null;
        }

        // Se deixar de ser formador, remove as turmas associadas como formador.
        if ((int) $validated['role_id'] !== Role::FORMADOR_ID) {
            $user->turmasComoFormador()->sync([]);
        }

        $user->save();

        return response()->json([
            'message' => 'User updated successfully.',
            'user' => $user->load(['role', 'turma', 'turmasComoFormador']),
        ]);
    }

    // Atualiza as turmas atribuídas a um formador.
    public function updateFormadorTurmas(Request $request, User $user)
    {
        $validated = $request->validate([
            'turma_ids' => ['array'],
            'turma_ids.*' => ['exists:turmas,id'],
        ]);

        // Apenas utilizadores formadores podem receber turmas.
        if (!$user->isFormador()) {
            return response()->json([
                'message' => 'This user is not a teacher.',
            ], 422);
        }

        $user->turmasComoFormador()->sync($validated['turma_ids'] ?? []);

        return response()->json([
            'message' => 'Teacher classes updated successfully.',
            'user' => $user->load('turmasComoFormador'),
        ]);
    }
}
