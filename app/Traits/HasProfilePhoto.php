<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use League\Glide\Server;

trait HasProfilePhoto
{

    /**
     * Update the image.
     *
     * @param \Illuminate\Http\UploadedFile $photo
     * @return void
     */
    public function updatePhoto(UploadedFile $photo)
    {
        tap($this->profile_photo_path, function ($previous) use ($photo) {
            $this->forceFill([
                'profile_photo_path' => $photo->store(
                    'profile-photos',
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
    public function getPhotoUrlAttribute(): string
    {
        return $this->profile_photo_path
            ? route('image.show', ['path' => $this->image_path, 'w' => 34, 'h' => 34, 'fit' => 'crop', 'fm' => 'webp'])
            : asset('images/webp/user.webp');
    }

    /**
     * Delete the item's image.
     *
     * @return void
     */
    public function deletePhoto()
    {
        Storage::disk('public')->delete($this->profile_photo_path);

        $this->forceFill([
            'profile_photo_path' => null,
        ])->save();
    }
}
