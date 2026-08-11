<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreativeDna extends Model
{
    protected $table = 'creative_dna_files';

    protected $fillable = [
        'user_id',
        'original_name',
        'path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
