<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Renomeia a tabela "moodboards" para "projects" preservando os dados.
     * Também corrige o registo da migração original, que foi renomeada para
     * "2026_08_11_000000_create_projects_table".
     */
    public function up(): void
    {
        // A migração original foi renomeada (moodboards -> projects).
        // Remove o registo antigo para quem já a tinha executado.
        DB::table('migrations')
            ->where('migration', '2026_08_11_000000_create_moodboards_table')
            ->delete();

        if (Schema::hasTable('moodboards') && !Schema::hasTable('projects')) {
            // Cenário normal: só existe a tabela antiga -> renomeia.
            Schema::rename('moodboards', 'projects');
        } elseif (Schema::hasTable('moodboards') && Schema::hasTable('projects')) {
            // A migração renomeada já criou "projects" (vazia) antes desta.
            // Copia os dados antigos para "projects" e remove a tabela antiga.
            $rows = DB::table('moodboards')->get();
            foreach ($rows as $row) {
                DB::table('projects')->insert([
                    'id' => $row->id,
                    'user_id' => $row->user_id,
                    'title' => $row->title,
                    'images' => $row->images,
                    'created_at' => $row->created_at,
                    'updated_at' => $row->updated_at,
                ]);
            }
            Schema::drop('moodboards');
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('projects') && !Schema::hasTable('moodboards')) {
            Schema::rename('projects', 'moodboards');
        }
    }
};
