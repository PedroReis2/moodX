<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('moodboards', function (Blueprint $table) {
            // para guardar caminhos das imagens do projeto, para exibir no moodboard e nao mostrar duplicados
            $table->json('project_image_paths')->nullable()->after('dna_image_ids');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('moodboards', function (Blueprint $table) {
            $table->dropColumn('project_image_paths');
        });
    }
};
