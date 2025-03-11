<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\ViewFlag;
use App\Services\FileUploadService;

class PhotoAdminController extends Controller
{
    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function entry(Request $request)
    {
        if($request->FILTER<>"ALL"){
            $imgList = Image::where('TALENT_ID', null)
            ->where('VIEW_FLG', $request->FILTER)
            ->orderBy('VIEW_FLG')->orderBy('PRIORITY')->get();
        }else{
            $imgList = Image::where('TALENT_ID', null)
            ->orderBy('VIEW_FLG')->orderBy('PRIORITY')->get();
        }
        return redirect()->route('admin')
        ->with('imgList', $imgList)
        ->with('filter', $request->FILTER)
        ->with('activeTab', 'photos-entry');
    }

    public function upload(Request $request)
    {
        $uploadedFiles = $request->file('upfile');

        $filePath = 'img/hp';
        $result = $this->fileUploadService->uploadFiles($uploadedFiles, $filePath, null, null, null);
        if ($result['success']) {
            return redirect()->route('admin')
            ->with('message', 'ファイルが正常にアップロードされました。')
            ->with('activeTab', 'photos-entry');
        } else {
            return redirect()->route('admin')
            ->with('error', 'ファイルのアップロードに失敗しました: ' . $result['message'])
            ->with('activeTab', 'photos-entry');
        }
    }

    public function update(Request $request)
    {
        $img = Image::where('FILE_NAME', $request->FILE_NAME)->first();
        $img->update([
            'VIEW_FLG' => $request->VIEW_FLG_AFT,
            'PRIORITY' => $request->PRIORITY
        ]);
        return redirect()->route('admin')
        ->with('message', '写真の表示設定が変更されました。')
        ->with('activeTab', 'photos-entry');
    }

    public function delete(Request $request)
    {
        $img = Image::where('FILE_NAME', $request->FILE_NAME)->first();
        if ($img) {
            $this->fileUploadService->deleteFile($img->FILE_PATH . $img->FILE_NAME);
            $img->delete();
            return redirect()->route('admin')
            ->with('message', '写真が削除されました。')
            ->with('activeTab', 'photos-entry');
        }
        return redirect()->route('admin')
        ->with('error', '写真の削除に失敗しました。')
        ->with('activeTab', 'photos-entry');
    }

    public function bulkUpdate(Request $request)
    {
        foreach($request->SELECTED_PHOTOS as $photo){
            $img = Image::where('FILE_NAME', $photo);
            $img->update([
                'VIEW_FLG' => $request->BULK_VIEW_FLG,
                'PRIORITY' => $request->PRIORITY
            ]);
        }
        return redirect()->route('admin')
        ->with('message', '写真の表示設定が変更されました。')
        ->with('activeTab', 'photos-entry');
    }
}
