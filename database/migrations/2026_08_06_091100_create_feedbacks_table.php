<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('formador_id')->constrained('users')->cascadeOnDelete();

            // relacao polimorfica: feedbackable_type = App\Models\Project ou App\Models\Moodboard
            $table->morphs('feedbackable');

            $table->text('content');
            $table->timestamps();

            $table->index('formador_id'); // acelera o historico de feedbacks do formador
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
};
