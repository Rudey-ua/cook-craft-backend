<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait FIleTrait
{
    public function uploadFile($file, string $path): string|false
    {
        $filename = uniqid('', true).'_'.str_replace(' ', '_', ($file->getClientOriginalName() ?? 'image'));

        $path = Storage::disk('public')->putFileAs($path, $file, $filename);

        return $path ? $filename : false;
    }
    protected function deleteOldFile($filename): void
    {
        if ($filename && Storage::disk('public')->exists('profile_images/' . $filename)) {
            Storage::disk('public')->delete('profile_images/' . $filename);
        }
    }

    public function getProfileImageUrl($filename): ?string
    {
        if (!$filename) {
            return null;
        }
        return Storage::disk('public')->url('profile_images/' . $filename);
    }
}
