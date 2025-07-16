<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use App\Models\Image;
use Illuminate\Support\Facades\Log;

class FileUploadService
{
    public function uploadFiles($files, $uploadDir, $talentId, $newsId, $priority)
    {
        // 単一のファイルの場合は配列に変換
        if (!is_array($files)) {
            $files = [$files];
        }

        $errors = []; // エラーメッセージを格納する配列
        $successCount = 0; // 成功したファイルの数をカウント

        foreach ($files as $file) {
            if ($file->isValid()) {
                $originalFileName = $file->getClientOriginalName();
                $size = $file->getSize();
                $maxSize = 50 * 1024 * 1024; // 50MB

                // ファイルサイズチェック
                if ($size > $maxSize) {
                    $errors[] = "「{$originalFileName}」はサイズ上限(50MB)を超えています。";
                    Log::warning("ファイルサイズが制限を超えています: {$originalFileName}, サイズ: {$size}");
                    continue;
                }

                $mimeType = $file->getMimeType();
                $allowedMimeTypes = [
                    'image/jpeg',
                    'image/png',
                    'image/gif',
                    'video/mp4',
                    'video/quicktime',
                    'video/webm'
                ];

                // MIMEタイプチェック
                if (!in_array($mimeType, $allowedMimeTypes)) {
                    $errors[] = "「{$originalFileName}」は許可されていないファイル形式です。";
                    Log::warning("無効なファイルタイプです: {$originalFileName}, タイプ: {$mimeType}");
                    continue;
                }

                try {
                    $extension = $file->getClientOriginalExtension();
                    $uniqueId = uniqid();
                    $newFileName = pathinfo($originalFileName, PATHINFO_FILENAME) . '_' . $uniqueId . '.' . $extension;

                    $file->storeAs($uploadDir, $newFileName, 'public');

                    Image::create([
                        'FILE_NAME' => $newFileName,
                        'FILE_PATH' => 'storage/' . $uploadDir . '/',
                        'TALENT_ID' => $talentId,
                        'NEWS_ID' => $newsId,
                        'VIEW_FLG' => ($newsId !== null) ? 'S501' : '00',
                        'PRIORITY' => 0
                    ]);

                    $successCount++;
                } catch (\Exception $e) {
                    $errors[] = "「{$originalFileName}」のアップロード中にサーバーエラーが発生しました。";
                    Log::error("ファイルのアップロード中にエラーが発生しました: {$originalFileName}. エラー: " . $e->getMessage());
                }
            } else {
                $errors[] = "無効なファイルが選択されました。";
                Log::warning("無効なファイルです。");
            }
        }

        // 成功メッセージとエラーメッセージを返すように変更
        return [
            'success' => $successCount > 0 && empty($errors),
            'errors' => $errors,
            'message' => $successCount > 0 ? "{$successCount}件のファイルがアップロードされました。" : ''
        ];
    }

    public function deleteFile($filePath)
    {
        if (Storage::disk('public')->delete(str_replace('storage/', '', $filePath))) {
            return true;
        }
        return false;
    }
}
