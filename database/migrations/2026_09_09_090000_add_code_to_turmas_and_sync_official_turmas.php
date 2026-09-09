<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $officialTurmas = [
        [
            'name' => '1º ano do curso de Design de Moda',
            'code' => '91P301A47422501',
        ],
        [
            'name' => '2º ano do curso de Design de Moda',
            'code' => '91P201A42112401',
        ],
        [
            'name' => '3º ano do curso de Design de Moda',
            'code' => '91P201A41342501',
        ],
    ];

    public function up(): void
    {
        Schema::table('turmas', function (Blueprint $table) {
            if (!Schema::hasColumn('turmas', 'code')) {
                // Código oficial da turma fornecido pela Carla/empresa.
                $table->string('code')->nullable()->unique()->after('id');
            }
        });

        foreach ($this->officialTurmas as $turma) {
            DB::table('turmas')->updateOrInsert(
                ['code' => $turma['code']],
                [
                    'name' => $turma['name'],
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }

        // Para já o projeto só usa estas 3 turmas oficiais.
        // As turmas antigas são removidas e as ligações antigas ficam limpas pelas foreign keys.
        DB::table('turmas')
            ->where(function ($query) {
                $query->whereNull('code')
                    ->orWhereNotIn('code', array_column($this->officialTurmas, 'code'));
            })
            ->delete();
    }

    public function down(): void
    {
        Schema::table('turmas', function (Blueprint $table) {
            if (Schema::hasColumn('turmas', 'code')) {
                $table->dropUnique(['code']);
                $table->dropColumn('code');
            }
        });
    }
};
