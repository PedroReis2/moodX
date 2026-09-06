<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    // IDs fixos usados para identificar os diferentes tipos de utilizador.
    public const ADMIN_ID = 1;
    public const FORMADOR_ID = 2;
    public const ALUNO_ID = 3;

    // Campos que podem ser preenchidos através de atribuição em massa.
    protected $fillable = ['name', 'permission'];
}
