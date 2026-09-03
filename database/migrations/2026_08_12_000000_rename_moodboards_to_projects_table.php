<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Esta migration ficou da fase antiga do projeto, quando moodboards virou projects.
     * Hoje a app já usa projects, então só faço algo se for mesmo uma base antiga.
     */
    public function up(): void
    {
        // Se projects já existe, não mexo em moodboards para evitar conflitos com foreign keys antigas.
        if (Schema::hasTable('projects')) {
            return;
        }

        // Só renomeio moodboards quando for uma base antiga onde projects ainda não existe.
        if (Schema::hasTable('moodboards')) {
            Schema::rename('moodboards', 'projects');
        }
    }

    public function down(): void
    {
        // Rollback defensivo: só renomeio de volta se moodboards ainda não existir.
        if (Schema::hasTable('projects') && !Schema::hasTable('moodboards')) {
            Schema::rename('projects', 'moodboards');
        }
    }
};
