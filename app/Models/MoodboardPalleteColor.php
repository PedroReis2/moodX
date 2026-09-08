<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MoodboardPaletteColor extends Model
{
    protected $fillable = [
        'moodboard_id',
        'hex_color',
        'source',
        'position',
    ];

    public function moodboard()
    {
        return $this->belongsTo(Moodboard::class);
    }
}