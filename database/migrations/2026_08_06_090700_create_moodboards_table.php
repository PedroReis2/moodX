<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('moodboards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->boolean('is_public')->default(false);
            $table->timestamps();

            $table->index('is_public'); // acelera a query da homepage
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('moodboards');
    }
};
