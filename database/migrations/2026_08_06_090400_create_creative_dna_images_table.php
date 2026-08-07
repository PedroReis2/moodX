<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('creative_dna_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('creative_dna_id')->constrained('creative_dna')->cascadeOnDelete();
            $table->string('image_path');

            // vetor CLIP (gerado apos upload, em modo de inferencia)
            $table->json('embedding')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('creative_dna_images');
    }
};
