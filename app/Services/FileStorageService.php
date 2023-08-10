<?php

namespace App\Services;

use App\Services\Contracts\FileStorageServiceContract;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class FileStorageService implements FileStorageServiceContract
{

    public static function upload(string|UploadedFile $file)
    {
        if (is_string($file)) {
            return str_replace('public/storage', '', $file);
        }

        $filePath = 'public/' . Str::random() . '_' . date('Y-m-d_h:m:s') . '.' . $file->getClientOriginalExtension();

        // Сохраняем оригинальное изображение
        Storage::put($filePath, File::get($file));

        // Открываем оригинальное изображение с помощью Intervention Image
        $image = Image::make(storage_path('app/' . $filePath));

        // Изменяем размер изображения до 256x256
        $image->resize(256, 256);
        $image->orientate();

        // Путь для сохранения измененного изображения
        $thumbnailPath = 'public/thumbnails/' . Str::random() . '_' . date('Y-m-d_h:m:s') . '.' . $file->getClientOriginalExtension();

        // Сохраняем измененное изображение
        Storage::put($thumbnailPath, (string) $image->encode());

        return $thumbnailPath;
    }

    public static function remove(string $file)
    {
        Storage::delete($file);
    }
}
