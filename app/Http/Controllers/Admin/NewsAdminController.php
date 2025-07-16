<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Image;
use App\Services\FileUploadService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Tag;

class NewsAdminController extends Controller
{
    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function entry()
    {
        $newsList = News::with(['tags', 'images'])->orderBy('POST_DATE', 'desc')->get();
        session()->flash('activeTab', 'news-entry');
        return view('admin', compact('newsList',));
    }

    public function store(Request $request)
    {
        $newsInfo = $request->only(['TITLE', 'POST_DATE', 'CONTENT']);
        $newsInfo['published_status'] = $request->has('published_status') ? 1 : 0;
        $news = News::create($newsInfo);
        $newsId = $news->NEWS_ID;

        // ★★★ タグの処理を追記 ★★★
        $this->syncTags($news, $request->input('tags'));

        $uploadedFiles = $request->file('upfile');
        $filePath = 'img/news/' . $newsId;
        session()->flash('activeTab', 'news-entry');

        if ($uploadedFiles <> null) {
            $result = $this->fileUploadService->uploadFiles($uploadedFiles, $filePath, null, $newsId, $request->PRIORITY);
            if ($result['success']) {
                return redirect()->route('admin', ['tab' => 'news-entry'])
                    ->with('message', 'ニュースが登録されました');
            } else {
                return redirect()->route('admin', ['tab' => 'news-entry'])
                    ->with('error', 'ファイルのアップロードに失敗しました: ' . $result['message']);
            }
        }
        return redirect()->route('admin', ['tab' => 'news-entry'])
            ->with('message', 'ニュースが登録されました');
    }

    public function update(Request $request, $id)
    {
        $news = News::findOrFail($id);

        $newsInfo = $request->only(['TITLE', 'POST_DATE', 'CONTENT']);
        $newsInfo['published_status'] = $request->has('published_status') ? 1 : 0;
        $news->update($newsInfo);

        $this->syncTags($news, $request->input('tags'));

        $uploadedFiles = $request->file('upfile');
        $filePath = 'img/news/' . $id;
        session()->flash('activeTab', 'news-entry');

        if ($uploadedFiles <> null) {
            $result = $this->fileUploadService->uploadFiles($uploadedFiles, $filePath, null, $id, $request->PRIORITY);
            if ($result['success']) {
                return redirect()->route('admin', ['tab' => 'news-entry'])
                    ->with('message', 'ニュースが更新されました');
            } else {
                return redirect()->route('admin', ['tab' => 'news-entry'])
                    ->with('error', 'ファイルのアップロードに失敗しました: ' . $result['message']);
            }
        }
        return redirect()->route('admin', ['tab' => 'news-entry'])
            ->with('message', 'ニュースが更新されました');
    }

    public function delete($id)
    {
        News::destroy($id);

        if (Storage::disk('public')->deleteDirectory('img/news/' . $id)) {
            return redirect()->route('admin', ['tab' => 'news-entry'])
                ->with('message', 'ニュースが削除されました。')
                ->with('activeTab', 'news-entry');
        }
        return redirect()->route('admin', ['tab' => 'news-entry'])
            ->with('error', '削除に失敗しました。')
            ->with('activeTab', 'news-entry');
    }

    public function priority(Request $request)
    {
        $img = Image::where('FILE_NAME', $request->FILE_NAME)->first();
        $img->update(['PRIORITY' => $request->PRIORITY]);
        return redirect()->route('admin', ['tab' => 'news-entry'])
            ->with('error', '優先度を更新しました')
            ->with('activeTab', 'news-entry');
    }

    public function getImages($id)
    {
        // Eloquentを使用して、必要なカラムのみを明示的に取得する
        $images = Image::where('NEWS_ID', $id)
            ->select('FILE_NAME', 'FILE_PATH', 'NEWS_ID', 'TALENT_ID') // 必要なカラムを明記
            ->get();

        return response()->json($images);
    }

    // ↓ この deleteImage メソッドを追記
    public function deleteImage($id)
    {
        try {
            // 画像IDではなく、ファイル名で検索するように変更
            $image = DB::table('images')->where('FILE_NAME', $id)->first();

            if ($image) {
                // ファイルパスから 'storage/' を除外してStorageファサードで扱えるようにする
                $filePath = str_replace('storage/', '', $image->FILE_PATH . $image->FILE_NAME);
                Storage::disk('public')->delete($filePath);

                // データベースレコードの削除
                DB::table('images')->where('FILE_NAME', $id)->delete();

                return response()->json(['success' => true, 'message' => '画像が正常に削除されました。']);
            } else {
                return response()->json(['success' => false, 'error' => '画像が見つかりません。'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => '画像の削除中にエラーが発生しました。', 'details' => $e->getMessage()], 500);
        }
    }

    /**
     * ★★★ このメソッドを追記 ★★★
     * タグの同期処理
     */
    private function syncTags(News $news, ?string $tagString): void
    {
        if (is_null($tagString)) {
            $news->tags()->sync([]);
            return;
        }

        $tagNames = array_map('trim', explode(',', $tagString));
        $tagIds = [];

        foreach ($tagNames as $tagName) {
            if (empty($tagName)) continue;

            $tag = Tag::firstOrCreate(
                ['TAG_NAME' => $tagName],
                ['TAG_COLOR' => '#' . substr(md5(rand()), 0, 6)]
            );
            $tagIds[] = $tag->TAG_ID;
        }

        $news->tags()->sync($tagIds);
    }
}
