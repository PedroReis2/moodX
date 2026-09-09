<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{
    use HasFactory;

    // Campos que podem ser preenchidos ao criar ou editar uma turma.
    protected $fillable = [
        'name',
        'code',
        'description',
    ];

    // Alunos associados a esta turma.
    public function alunos()
    {
        return $this->hasMany(User::class)->where('role_id', Role::ALUNO_ID);
    }

    // Formadores associados a esta turma.
    public function formadores()
    {
        return $this->belongsToMany(User::class, 'turma_formador');
    }
}
