<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedbacks';

    protected $fillable = [
        'formador_id',
        'feedbackable_id',
        'feedbackable_type',
        'content',
    ];

    // Projeto ou moodboard que recebeu o feedback.
    public function feedbackable()
    {
        return $this->morphTo();
    }

    // Professor que escreveu o feedback.
    public function formador()
    {
        return $this->belongsTo(User::class, 'formador_id');
    }
}
