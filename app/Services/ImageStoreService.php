<?php

namespace App\Services;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

/**
 * Class MovieService
 * @package App\Services
 */
class ImageStoreService
{
     /**
     * Handle storing an image file.
     *
     * @param string $destinationPath The destination path where the image will be stored.
     * @param mixed $file The image file to store.
     * @return string|false The path where the image is stored, or false if there was an issue storing the file.
     */
    public function handle($destinationPath='public/images', $file)
    {
        
        $imageName = rand(666561, 544614449) . '-' . time() . '.' . $file->extension();
        $path = $file->storePubliclyAs($destinationPath, $imageName);

        # were created but are corrupt
        $fileSize = Storage::size($path);
        if ($fileSize === false) {
            return false;
        }

        return $path;
                
    }
}