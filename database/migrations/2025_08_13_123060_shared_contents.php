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
        Schema::create('shared_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sketchbook_entry_id')->constrained('sketchbook_entries')->onDelete('cascade');
            $table->json('user_ids')->nullable(); // array de IDs dos usuários
            $table->string('permissions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shared_contents');
    }
};
