<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Remove as tabelas do produto anterior (sketchbooks) que foram
     * substituidas por creative_dna + projects + moodboards, e as
     * tabelas de conversas/comentarios/partilha que nao se aplicam
     * ao produto atual (Mood.X v1.0 - paleta de cores, nao chat).
     *
     * IMPORTANTE: correr esta migration DEPOIS das tabelas novas
     * estarem criadas, e so em ambiente de dev / apos backup, ja
     * que estas tabelas podem ter dados.
     */
    public function up(): void
    {
        Schema::dropIfExists('comments');
        Schema::dropIfExists('shared_contents');
        Schema::dropIfExists('sketchbook_entries');
        Schema::dropIfExists('sketchbooks');
        Schema::dropIfExists('messages');
        Schema::dropIfExists('conversations');
        Schema::dropIfExists('ai_requests');
    }

    public function down(): void
    {
        // Sem rollback: estas tabelas nao voltam a ser recriadas.
        // Se precisares de reverter, restaura o backup SQL original.
    }
};
