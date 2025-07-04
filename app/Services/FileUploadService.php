<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use App\Models\Image;

class FileUploadService
{
    public function uploadFiles($files, $uploadDir, $talentId, $newsId, $priority)
    {
        // 単一のファイルの場合は配列に変換
        if (!is_array($files)) {
            $files = [$files];
        }

        foreach ($files as $file) {
            // ファイルが有効かチェック
            if ($file->isValid()) {
                // 元のファイル名
                $originalFileName = $file->getClientOriginalName();

                // ファイルの拡張子
                $extension = $file->getClientOriginalExtension();

                // ファイルのMIMEタイプ
                $mimeType = $file->getMimeType();

                // ファイルサイズ（バイト）
                $size = $file->getSize();

                // ファイルサイズの制限（5MB）
                $maxSize = 5 * 1024 * 1024; // 5MB in bytes

                if ($size > $maxSize) {
                    \Log::warning("ファイルサイズが制限を超えています: {$originalFileName}, サイズ: {$size}");
                    continue; // 次のファイルへ
                }

                // 許可されるMIMEタイプ
                $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];

                if (!in_array($mimeType, $allowedMimeTypes)) {
                    \Log::warning("無効なファイルタイプです: {$originalFileName}, タイプ: {$mimeType}");
                    continue; // 次のファイルへ
                }

                try {
                    // ユニークなIDを生成
                    $uniqueId = uniqid();

                    // 新しいファイル名を生成（元のファイル名 + ユニークID + 拡張子）
                    $newFileName = pathinfo($originalFileName, PATHINFO_FILENAME) . '_' . $uniqueId . '.' . $extension;

                    // ファイルを保存
                    $storedPath = $file->storeAs($uploadDir, $newFileName, 'public');
                    $viewFlg = '00';
                    $pr = 0;
                    if ($newsId <> null) {
                        $viewFlg = 'S501';
                        $pr = 0;
                    }
                    // DBへ保存
                    Image::create([
                        'FILE_NAME' => $newFileName,
                        'FILE_PATH' => 'storage/' . $uploadDir . '/',
                        'TALENT_ID' => $talentId,
                        'NEWS_ID' => $newsId,
                        'VIEW_FLG' => $viewFlg,
                        'PRIORITY' => $pr
                    ]);

                    \Log::info("ファイルがアップロードされました: 元のファイル名: {$originalFileName}, 新しいファイル名: {$newFileName}, サイズ: {$size}, タイプ: {$mimeType}, 保存先: {$storedPath}");
                } catch (\Exception $e) {
                    \Log::error("ファイルのアップロード中にエラーが発生しました: {$originalFileName}. エラー: " . $e->getMessage());
                }
            } else {
                \Log::warning("無効なファイルです: {$file->getClientOriginalName()}");
            }
        }
        return ['success' => true, 'message' => 'ファイルが正常にアップロードされました。'];
    }

    public function deleteFile($filePath)
    {

        if (Storage::disk('public')->delete(str_replace('storage/', '', $filePath))) {
            return true;
        }
        return false;
    }
}
