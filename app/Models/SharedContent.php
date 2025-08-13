<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SharedContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'sketchbook_entry_id',
        'user_ids', // array/json de IDs de usuários
        'permissions',
    ];

    public function sketchbookEntry()
    {
        return $this->belongsTo(SketchbookEntry::class);
    }
}
