<?php

namespace App\Helpers\File;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileUploadHelper
{
    public static function upload(UploadedFile $file,string $directory = '',string $disk = 'public'): string
    {
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

        $path = 'uploads';

        if (!empty($directory)) {
            $path .= '/' . trim($directory, '/');
        }

        return $file->storeAs($path, $filename, $disk);
    }

    public static function delete(?string $path, string $disk = 'public'): bool
    {
        if (blank($path)) {
            return false;
        }

        if (Storage::disk($disk)->exists($path)) {
            return Storage::disk($disk)->delete($path);
        }

        return false;
    }

    public static function replace(UploadedFile $file,?string $oldPath,string $directory = '',string $disk = 'public'): string
    {
        self::delete($oldPath, $disk);

        return self::upload($file, $directory, $disk);
    }
}
