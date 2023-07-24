<?php

namespace App\Services;

use App\Models\Movie;
use Illuminate\Support\Facades\Storage;

/**
 * Class MovieService
 * @package App\Services
 */
class ImageStoreService {
    /**
     * Handle storing an image file.
     *
     * @param string $destinationPath The destination path where the image will be stored.
     * @param mixed $file The image file to store.
     * @return string|false The path where the image is stored, or false if there was an issue storing the file.
     */
    public function handle( $destinationPath = 'public/images', $file ) {

        $imageName = rand( 666561, 544614449 ) . '-' . time() . '.' . $file->extension();
        $path = $file->storePubliclyAs( $destinationPath, $imageName );

        # were created but are corrupt
        $fileSize = Storage::size( $path );
        if ( $fileSize === false ) {
            return false;
        }

        return $path;

    }

    /**
     * Handle storing an image file from base64 data.
     *
     * @param string $destinationPath The destination path where the image will be stored.
     * @param string $base64Data The base64 encoded image data to store.
     * @return string|false The path where the image is stored, or false if there was an issue storing the file.
     */
    public function handleBase64( $destinationPath = 'public/images', $base64Data ) {
        // Extract image format and data from the base64 string
        $matches = [];
        preg_match( '/data:image\/(.*?);base64,(.*)/', $base64Data, $matches );

        if ( count( $matches ) !== 3 ) {
            // Invalid base64 data format
            return false;
        }

        $imageFormat = $matches[1]; // Get the image format (e.g., 'jpeg', 'png', 'gif', etc.)
        $imageData = base64_decode( $matches[2] ); // Get the binary image data

        // Generate a unique image name
        $imageName = rand( 666561, 544614449 ) . '-' . time() . '.' . $imageFormat;

        // Determine the full path to save the image
        $path = $destinationPath . '/' . $imageName;

        // Save the image to the specified path
        $isStored = Storage::put( $path, $imageData );

        if ( !$isStored ) {
            return false;
        }

        return $path;
    }

}