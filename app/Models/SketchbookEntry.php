<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SketchbookEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'sketchbook_id',
        'content_type',
        'content_url',
        'content_text',
    ];

    public function sketchbook()
    {
        return $this->belongsTo(Sketchbook::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function sharedContents()
    {
        return $this->hasMany(SharedContent::class);
    }
}
