<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\UploadedFile;

class StoreImagesService
{
    /**
     * @param UploadedFile $image
     * @param string $entityName
     * @param int $entityId
     * @return string
     */
    public function save(UploadedFile $image, string $entityName, int $entityId): string
    {
        $imageName = $image->getClientOriginalName();
        $imagePath = $image->storeAs("/images/$entityName/" . $entityId, $imageName, 'public');

        return 'storage/' . $imagePath;
    }

    /**
     * @param UploadedFile[] $images
     * @param string $entityName
     * @param int $entityId
     * @return array
     */
    public function massSave(array $images, string $entityName, int $entityId): array
    {
        $paths = [];

        foreach ($images as $image) {
            $paths[] = $this->save($image, $entityName, $entityId);
        }

        return $paths;
    }
}
