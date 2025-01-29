<?php

namespace App\Services;

use ImageKit\ImageKit;
use Exception;

class ImageKitService
{
    protected $imageKit;

    public function __construct()
    {
        $this->imageKit = new ImageKit(
            env('IMAGEKIT_PUBLIC_KEY'),
            env('IMAGEKIT_PRIVATE_KEY'),
            env('IMAGEKIT_URL_ENDPOINT')
        );
    }

    public function upload($file, $fileName, $folder = '')
    {
        try {
            // Baca file sebagai base64
            $fileContent = base64_encode(file_get_contents($file->getRealPath()));

            $upload = $this->imageKit->uploadFile([
                'file' => $fileContent,           // Kirim sebagai base64
                'fileName' => $fileName,
                'folder' => $folder,
                'useUniqueFileName' => true,      // Gunakan nama file unik
                'overwriteFile' => false,         // Jangan overwrite file yang sudah ada
                'responseFields' => [             // Minta informasi tambahan
                    "tags",
                    "customCoordinates",
                    "metadata",
                    "dimensions"
                ]
            ]);

            return $upload->result->url; // Mengembalikan URL gambar
        } catch (Exception $e) {
            throw new Exception('ImageKit Upload Error: ' . $e->getMessage());
        }
    }
}
