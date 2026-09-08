<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MoodboardLike extends Model
{
    protected $fillable = [
        'moodboard_id',
        'user_id',
    ];

    const UPDATED_AT = null;

    public function moodboard()
    {
        return $this->belongsTo(Moodboard::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}