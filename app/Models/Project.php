<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'projects';

    protected $fillable = [
        'user_id',
        'title',
        'images',
        'image_colors',
        'palette',
    ];

    // Converte os campos JSON da BD em arrays PHP para facilitar o uso no controller e no frontend.
    protected $casts = [
        'images' => 'array',
        'image_colors' => 'array',
        'palette' => 'array',
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
