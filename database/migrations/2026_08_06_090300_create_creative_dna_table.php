<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('creative_dna', function (Blueprint $table) {
            $table->id();

            // unique -> garante 1 creative_dna por conta a nivel de BD
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();

            // pending: ainda a receber imagens (15-20, validado na aplicação)
            // trained: treino concluido, imagens tornam-se imutaveis (regra aplicada na app/policy)
            $table->enum('status', ['pending', 'trained'])->default('pending');
            $table->timestamp('trained_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('creative_dna');
    }
};
