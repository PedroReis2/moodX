<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Campos que podem ser preenchidos quando criamos/editamos um utilizador.
    protected $fillable = [
        'first_name',
        'last_name',
        'name',
        'email',
        'password',
        'role_id',
        'turma_id',
        'classified_at',
    ];

    // Campos escondidos quando o utilizador é devolvido em JSON.
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Conversões automáticas feitas pelo Laravel.
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'classified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Role do utilizador: admin, formador ou aluno.
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Perfil associado ao utilizador.
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    // Projetos criados pelo utilizador.
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    // Turma onde o aluno está inserido.
    public function turma()
    {
        return $this->belongsTo(Turma::class);
    }

    // Turmas que este formador acompanha.
    public function turmasComoFormador()
    {
        return $this->belongsToMany(Turma::class, 'turma_formador');
    }

    // Verifica se o utilizador é administrador.
    public function isAdmin(): bool
    {
        return $this->role_id === Role::ADMIN_ID;
    }

    // Verifica se o utilizador é formador.
    public function isFormador(): bool
    {
        return $this->role_id === Role::FORMADOR_ID;
    }

    // Verifica se o utilizador é aluno.
    public function isAluno(): bool
    {
        return $this->role_id === Role::ALUNO_ID;
    }
}
