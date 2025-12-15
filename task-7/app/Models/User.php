<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function getAvatarUrl()
    {
        if ($this->avatar && file_exists(public_path('avatars/' . $this->avatar))) {
            return asset('avatars/' . $this->avatar) . '?t=' . time();
        }
        
        return asset('images/default-avatar.svg');
    }
}