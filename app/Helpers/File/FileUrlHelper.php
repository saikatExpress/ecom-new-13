<?php

namespace App\Helpers\File;

use Illuminate\Support\Facades\Storage;

class FileUrlHelper
{
    public static function url(?string $path, string $disk = 'public'): ?string
    {
        if (blank($path)) {
            return null;
        }

        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        return Storage::disk($disk)->url($path);
    }
}
