<?php
namespace Utils;

class ConvertToWebP 
{
    // Converts an image to WebP format, resizes and crops it, and stores it in the specified location
    public function convertToWebP($source, $destination, $productSlug, $categoryId, $quality = 80)
    {
        // Reads the image from the source path
        $image = imagecreatefromstring(file_get_contents($source));
        if ($image !== false) 
        {
            // Resizes and crops the image to specified dimensions
            $finalImage = $this->resizeAndCropImage($image, 720, 960);
            if ($finalImage === false) {
                return false; // Returns false if resizing and cropping failed
            }

            // Constructs the final path for the WebP image file
            $webpImagePath = $destination . $productSlug . '-' . $categoryId . '.webp';

            // Saves the resized and cropped image as WebP
            if (imagewebp($finalImage, $webpImagePath, $quality)) 
            {
                // Frees up memory by destroying the original and resized images
                imagedestroy($image);
                imagedestroy($finalImage);
                
                // Deletes the original file as it's no longer needed
                unlink($source);

                // Returns the path to the newly created WebP image
                return $webpImagePath;
            } 
            else 
            {
                // If the WebP conversion fails, frees memory and returns false
                imagedestroy($image);
                imagedestroy($finalImage);
                return false;
            }
        } 
        else 
        {
            return false; // Returns false if loading the image fails
        }
    }

    // Resizes and crops the image to the target width and height while maintaining the aspect ratio
    private function resizeAndCropImage($image, $targetWidth, $targetHeight)
    {
        $originalWidth = imagesx($image);
        $originalHeight = imagesy($image);

        // Calculates the scaling ratio to fit the target dimensions
        $ratio = max($targetWidth / $originalWidth, $targetHeight / $originalHeight);

        // Computes new width and height based on the calculated ratio
        $newWidth = (int)($originalWidth * $ratio);
        $newHeight = (int)($originalHeight * $ratio);

        // Creates a new true color image with the resized dimensions
        $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
        if ($resizedImage === false) {
            return false; // Returns false if image creation fails
        }

        // Preserves transparency if the original image has an alpha channel
        if (imagealphablending($resizedImage, false)) {
            imagesavealpha($resizedImage, true);
            $transparent = imagecolorallocatealpha($resizedImage, 0, 0, 0, 127);
            imagefill($resizedImage, 0, 0, $transparent);
        }

        // Resizes the original image onto the resized image canvas
        if (!imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight)) {
            imagedestroy($resizedImage);
            return false; // Returns false if resizing fails
        }

        // Calculates offsets to center the image after resizing for the target dimensions
        $xOffset = ($newWidth - $targetWidth) / 2;
        $yOffset = ($newHeight - $targetHeight) / 2;

        // Creates the final image canvas with the target dimensions
        $finalImage = imagecreatetruecolor($targetWidth, $targetHeight);
        if ($finalImage === false) {
            return false; // Returns false if image creation fails
        }

        // Preserves transparency in the final cropped image
        if (imagealphablending($finalImage, false)) {
            imagesavealpha($finalImage, true);
            $transparent = imagecolorallocatealpha($finalImage, 0, 0, 0, 127);
            imagefill($finalImage, 0, 0, $transparent);
        }

        // Copies the centered, cropped portion of the resized image onto the final canvas
        if (!imagecopy($finalImage, $resizedImage, 0, 0, $xOffset, $yOffset, $targetWidth, $targetHeight)) {
            imagedestroy($resizedImage);
            imagedestroy($finalImage);
            return false; // Returns false if cropping fails
        }

        // Frees memory from the resized image as it's no longer needed
        imagedestroy($resizedImage);
        return $finalImage; // Returns the final resized and cropped image
    }
}
