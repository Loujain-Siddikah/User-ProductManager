<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;

class ImageHelper
{

    /**
     * Save the uploaded image and return the image path.
     *
     * @param UploadedFile $image The uploaded image file.
     * @param string $disk The disk to store the image (default: 'public').
     * @return bool|string The image path on success, false on failure.
     */
    public static function saveImage(UploadedFile $image, string $filename, string $disk = 'public'): bool|string
    {
        // Get the file extension from the original image.
        $extension = $image->getClientOriginalExtension();

        // Generate a unique filename with the 'avatar' directory and current timestamp.
        $filename = $filename .'/' . time() . '.' . $extension;

        // Store the image file with the generated filename in the specified disk.
        // Returns the image path on success, or false on failure.
        return $image->storeAs('', $filename, $disk);
    }
}