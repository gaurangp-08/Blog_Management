<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function hasLiked($model): bool
    {
        return $this->likes()
            ->where('likeable_type', get_class($model))
            ->where('likeable_id', $model->id)
            ->exists();
    }
}