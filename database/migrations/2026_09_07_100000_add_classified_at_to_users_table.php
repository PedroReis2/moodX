<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'classified_at')) {
                // Guarda quando o admin já decidiu se o user é student ou teacher.
                $table->timestamp('classified_at')->nullable()->after('turma_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'classified_at')) {
                $table->dropColumn('classified_at');
            }
        });
    }
};
