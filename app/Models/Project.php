<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Moodboard extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'images',
    ];

    protected $casts = [
        'images' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Capa do projeto — a primeira imagem carregada.
     */
    public function getCoverAttribute()
    {
        return $this->images[0] ?? null;
    }
}
