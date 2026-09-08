<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Moodboard extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'is_public',
        'dna_image_ids',
        'project_image_paths',
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'dna_image_ids' => 'array',
        'project_image_paths' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'moodboard_project');
    }

    public function paletteColors()
    {
        return $this->hasMany(MoodboardPaletteColor::class)->orderBy('position');
    }

    public function likes()
    {
        return $this->hasMany(MoodboardLike::class);
    }
}