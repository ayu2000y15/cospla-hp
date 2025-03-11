<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Image;
use App\Services\FileUploadService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class NewsAdminController extends Controller
{
    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function entry()
    {
        $newsList = News::all()->sortByDesc('POST_DATE');
        $newsImgList = Image::whereRaw('NEWS_ID is not null')->orderBy('NEWS_ID');
        session()->flash('activeTab', 'news-entry');
        return view('admin', compact('newsList', 'newsImgList'));
    }

    public function store(Request $request)
    {
        $newsInfo = $request->only(['TITLE', 'POST_DATE', 'CONTENT']);
        News::create($newsInfo);
        $newsId = News::max('NEWS_ID');

        $uploadedFiles = $request->file('upfile');
        $filePath = 'img/news/' . $newsId;
        session()->flash('activeTab', 'news-entry');

        if($uploadedFiles <> null){
            $result = $this->fileUploadService->uploadFiles($uploadedFiles, $filePath, null, $newsId, $request->PRIORITY);
            if ($result['success']) {
                return redirect()->route('admin')
                ->with('message', 'ニュースが登録されました');
            } else {
                return redirect()->route('admin')
                ->with('error', 'ファイルのアップロードに失敗しました: ' . $result['message']);
            }
        }
        return redirect()->route('admin')
                ->with('message', 'ニュースが登録されました');
    }

    public function update(Request $request, $id)
    {
        $news = News::findOrFail($id);

        $newsInfo = $request->only(['TITLE', 'POST_DATE', 'CONTENT']);
        $news->update($newsInfo);

        $uploadedFiles = $request->file('upfile');
        $filePath = 'img/news/' . $id;
        session()->flash('activeTab', 'news-entry');

        if($uploadedFiles <> null){
            $result = $this->fileUploadService->uploadFiles($uploadedFiles, $filePath, null, $id, $request->PRIORITY);
            if ($result['success']) {
                return redirect()->route('admin')
                ->with('message', 'ニュースが更新されました');
            } else {
                return redirect()->route('admin')
                ->with('error', 'ファイルのアップロードに失敗しました: ' . $result['message']);
            }
        }
        return redirect()->route('admin')
        ->with('message', 'ニュースが更新されました');
    }

    public function delete($id)
    {
        News::destroy($id);

        if (Storage::disk('public')->deleteDirectory('img/news/' . $id)){
            return redirect()->route('admin')
            ->with('message', 'ニュースが削除されました。')
            ->with('activeTab', 'news-entry');
        }
        return redirect()->route('admin')
        ->with('error', '削除に失敗しました。')
        ->with('activeTab', 'news-entry');
    }

    public function priority(Request $request)
    {
        $img = Image::where('FILE_NAME', $request->FILE_NAME)->first();
        $img->update(['PRIORITY' => $request->PRIORITY]);
        return redirect()->route('admin')
        ->with('error', '優先度を更新しました')
        ->with('activeTab', 'news-entry');
    }

    public function getImages($id)
    {
        $images = DB::table('images')
            ->where('NEWS_ID', $id)
            ->get();

        return response()->json($images);
    }

    public function deleteImage($id)
{
    try {
        $image = DB::table('images')->where('FILE_NAME', $id)->first();

        if ($image) {
            // 物理ファイルの削除
            $filePath = public_path($image->FILE_PATH . $image->FILE_NAME);
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // データベースレコードの削除
            DB::table('images')->where('FILE_NAME', $id)->delete();

            return response()->json(['success' => true, 'message' => '画像が正常に削除されました。']);
        } else {
            return response()->json(['success' => false, 'error' => '画像が見つかりません。'], 404);
        }
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'error' => '画像の削除中にエラーが発生しました。'], 500);
    }
}
}
