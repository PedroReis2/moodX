<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('moodboard_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('moodboard_id')->constrained('moodboards')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamp('created_at')->useCurrent();

            // garante, a nivel de BD, que um user so pode dar like 1x ao mesmo moodboard
            $table->unique(['moodboard_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('moodboard_likes');
    }
};
