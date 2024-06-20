<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use League\Glide\Server;

trait HasImage
{

    /**
     * Update the image.
     *
     * @param \Illuminate\Http\UploadedFile $image
     * @return void
     */
    public function updateImage(UploadedFile $image)
    {
        tap($this->image_path, function ($previous) use ($image) {
            $this->forceFill([
                'image_path' => $image->store(
                    'images',
                )
            ])->save();

            if ($previous) {
                Storage::disk('public')->delete($previous);
            }
        });
    }


    /**
     * Get the URL to the image.
     *
     * @return string
     */
    public function getImageUrlAttribute(): string
    {
        return $this->image_path
            ? route('image.show', ['path' => $this->image_path, 'w' => 512, 'h' => 512, 'fit' => 'fill-max', 'bg' => 'white', 'fm' => 'webp'])
            : asset('images/placeholder.webp');
    }

    /**
     * Delete the item's image.
     *
     * @return void
     */
    public function deleteImage()
    {
        if ($this->image_path) {
            Storage::disk('public')->delete($this->image_path);
        }

        $this->forceFill([
            'image_path' => null,
        ])->save();
    }
}
