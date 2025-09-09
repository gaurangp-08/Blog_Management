<?php
// app/Traits/LikeableTrait.php

namespace App\Traits;

use App\Models\Like;
use App\Models\User;

trait LikeableTrait
{
    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function isLikedBy(User $user): bool
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    public function toggleLike(User $user): array
    {
        $like = $this->likes()->where('user_id', $user->id)->first();

        if ($like) {
            $like->delete();
            $this->decrement('likes_count');
            return ['liked' => false, 'likes_count' => $this->fresh()->likes_count];
        } else {
            $this->likes()->create(['user_id' => $user->id]);
            $this->increment('likes_count');
            return ['liked' => true, 'likes_count' => $this->fresh()->likes_count];
        }
    }

    public function getIsLikedByUserAttribute(): bool
    {
        if (!auth('sanctum')->check()) {
            return false;
        }
        
        return $this->isLikedBy(auth('sanctum')->user());
    }
}