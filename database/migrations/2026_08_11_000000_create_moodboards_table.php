<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('moodboards', function (Blueprint $table) {
            // Até 5 caminhos de imagens do Creative DNA do utilizador
            $table->json('images')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('moodboards', function (Blueprint $table) {
            $table->dropColumn('images');
        });
    }
};
