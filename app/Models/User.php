<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'first_name', 'last_name', 'name', 'email', 'password', 'role_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function sketchbooks()
    {
        return $this->hasMany(Sketchbook::class);
    }

    public function moodboards()
    {
        return $this->hasMany(Moodboard::class);
    }

    public function aiRequests()
    {
        return $this->hasMany(AiRequest::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function sharedContents()
    {
        return $this->hasMany(SharedContent::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function conversations()
{
    return $this->hasMany(\App\Models\Conversation::class);
}
}
