<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use App\Models\Image;

class FileUploadService
{
    public function uploadFiles($files)
    {
        if (!is_array($files)) {
            $files = [$files];
        }

        $uploadedFiles = [];
        foreach ($files as $file) {
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = 'uploads/';
            
            if ($file->storeAs('public/' . $filePath, $fileName)) {
                Image::create([
                    'FILE_NAME' => $fileName,
                    'FILE_PATH' => $filePath,
                    'VIEW_FLG' => '0', // デフォルト値
                    'PRIORITY' => 0 // デフォルト値
                ]);
                $uploadedFiles[] = $fileName;
            }
        }

        if (count($uploadedFiles) > 0) {
            return ['success' => true, 'files' => $uploadedFiles];
        } else {
            return ['success' => false, 'message' => 'ファイルのアップロードに失敗しました。'];
        }
    }

    public function deleteFile($filePath)
    {
        if (Storage::delete('public/' . $filePath)) {
            return true;
        }
        return false;
    }
}