<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait ImageUploadTrait
{
    protected function uploadImage(UploadedFile $image, string $directory = 'blog-images'): string
    {
        $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
        return $image->storeAs($directory, $filename, 'public');
    }

    protected function deleteImage(?string $imagePath): bool
    {
        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            return Storage::disk('public')->delete($imagePath);
        }
        return false;
    }

    protected function getImageUrl(?string $imagePath): ?string
    {
        return $imagePath ? asset('storage/' . $imagePath) : null;
    }
}