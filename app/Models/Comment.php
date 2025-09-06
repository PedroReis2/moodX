<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sketchbook_entry_id',
        'comment',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sketchbookEntry()
    {
        return $this->belongsTo(SketchbookEntry::class);
    }

    // Alias para compatibilidade com whereHas('entry')
    public function entry()
    {
        return $this->sketchbookEntry();
    }
}
