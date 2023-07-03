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