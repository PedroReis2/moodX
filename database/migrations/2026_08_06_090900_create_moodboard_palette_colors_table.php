<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('moodboard_palette_colors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('moodboard_id')->constrained('moodboards')->cascadeOnDelete();
            $table->string('hex_color', 7); // ex: #A3B1C2

            // de onde veio esta cor: projeto (predominante) ou creative dna (assinatura pessoal)
            $table->enum('source', ['project', 'dna']);

            $table->unsignedTinyInteger('position'); // ordem de dominancia (0 = mais dominante)

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('moodboard_palette_colors');
    }
};
