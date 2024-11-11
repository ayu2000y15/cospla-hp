<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Image;
use App\Services\FileUploadService;

class PhotoAdminController extends Controller
{
    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function entry()
    {
        $imgList = Image::where('TALENT_ID', null)->get();
        $talentImgList = Image::whereNotNull('TALENT_ID')->get();
        $viewFlags = Image::select('VIEW_FLG', 'COMMENT')->distinct()->get();
        return view('admin.photos.entry', compact('imgList', 'talentImgList', 'viewFlags'));
    }

    public function upload(Request $request)
    {
        $uploadedFiles = $request->file('upfile');
        $result = $this->fileUploadService->uploadFiles($uploadedFiles);
        if ($result['success']) {
            return redirect()->route('admin.photos.entry')->with('message', 'ファイルが正常にアップロードされました。');
        } else {
            return redirect()->route('admin.photos.entry')->with('error', 'ファイルのアップロードに失敗しました: ' . $result['message']);
        }
    }

    public function update(Request $request)
    {
        $img = Image::where('FILE_NAME', $request->FILE_NAME)->first();
        $img->update([
            'VIEW_FLG' => $request->VIEW_FLG_AFT,
            'PRIORITY' => $request->PRIORITY
        ]);
        return redirect()->route('admin.photos.entry')->with('message', '写真の表示設定が変更されました。');
    }

    public function delete(Request $request)
    {
        $img = Image::where('FILE_NAME', $request->FILE_NAME)->first();
        if ($img) {
            $this->fileUploadService->deleteFile($img->FILE_PATH . $img->FILE_NAME);
            $img->delete();
            return redirect()->route('admin.photos.entry')->with('message', '写真が削除されました。');
        }
        return redirect()->route('admin.photos.entry')->with('error', '写真の削除に失敗しました。');
    }
}