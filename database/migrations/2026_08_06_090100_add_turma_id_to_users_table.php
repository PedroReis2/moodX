<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Nullable porque admins e formadores não usam este campo diretamente
            // (formador associa-se via tabela pivot turma_formador, admin não tem turma)
            $table->foreignId('turma_id')
                ->nullable()
                ->after('role_id')
                ->constrained('turmas')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('turma_id');
        });
    }
};
