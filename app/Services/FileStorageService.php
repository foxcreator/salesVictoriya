<?php

namespace App\Services;

use App\Services\Contracts\FileStorageServiceContract;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileStorageService implements FileStorageServiceContract
{

    public static function upload(string|UploadedFile $file)
    {
        if (is_string($file)){
            return str_replace('public/storage', '', $file);
        }

        $filePath = 'public/' . Str::random() . '_' . date('Y-m-d_h:m:s') . '.' . $file->getClientOriginalExtension();

        Storage::put($filePath, File::get($file));

        return $filePath;

    }

    public static function remove(string $file)
    {
        Storage::delete($file);
    }
}
