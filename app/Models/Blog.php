<?php

namespace App\Models;

use App\Traits\LikeableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Blog extends Model
{
    use HasFactory, LikeableTrait;

    protected $fillable = [
        'title',
        'description', 
        'image',
        'user_id',
        'likes_count'
    ];

    protected $appends = ['is_liked_by_user', 'image_url'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    // Scopes for filtering
    public function scopeMostLiked(Builder $query): Builder
    {
        return $query->orderBy('likes_count', 'desc');
    }

    public function scopeLatest(Builder $query): Builder
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });
    }

    public function scopeWithUserLikes(Builder $query, ?int $userId = null): Builder
    {
        if (!$userId) {
            return $query;
        }

        return $query->withExists([
            'likes as is_liked_by_current_user' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }
        ]);
    }
}