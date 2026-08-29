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
    Schema::table('creative_dna_files', function (Blueprint $table) {
        $table->json('colors')->nullable()->after('path');
    });

    Schema::table('projects', function (Blueprint $table) {
        $table->json('image_colors')->nullable()->after('images');
        $table->json('palette')->nullable()->after('image_colors');
    });
}

public function down(): void
{
    Schema::table('projects', function (Blueprint $table) {
        $table->dropColumn(['image_colors', 'palette']);
    });

    Schema::table('creative_dna_files', function (Blueprint $table) {
        $table->dropColumn('colors');
    });
}
};
