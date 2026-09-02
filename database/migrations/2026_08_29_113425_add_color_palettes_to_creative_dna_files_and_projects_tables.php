<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Adiciona os campos usados para guardar as cores extraídas e a paleta final.
     */
    public function up(): void
    {
        Schema::table('creative_dna_files', function (Blueprint $table) {
            // Guardo as cores extraídas de cada imagem do Creative DNA.
            if (!Schema::hasColumn('creative_dna_files', 'colors')) {
                $table->json('colors')->nullable()->after('path');
            }
        });

        Schema::table('projects', function (Blueprint $table) {
            // Algumas bases antigas já tinham projects, mas ainda não tinham o JSON das imagens.
            if (!Schema::hasColumn('projects', 'images')) {
                $table->json('images')->nullable()->after('title');
            }

            // Guardo as cores extraídas das imagens usadas em cada projeto.
            if (!Schema::hasColumn('projects', 'image_colors')) {
                $table->json('image_colors')->nullable()->after('images');
            }

            // Guardo a paleta final calculada com 30% Creative DNA e 70% projeto.
            if (!Schema::hasColumn('projects', 'palette')) {
                $table->json('palette')->nullable()->after('image_colors');
            }
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            if (Schema::hasColumn('projects', 'palette')) {
                $table->dropColumn('palette');
            }

            if (Schema::hasColumn('projects', 'image_colors')) {
                $table->dropColumn('image_colors');
            }
        });

        Schema::table('creative_dna_files', function (Blueprint $table) {
            if (Schema::hasColumn('creative_dna_files', 'colors')) {
                $table->dropColumn('colors');
            }
        });
    }
};
