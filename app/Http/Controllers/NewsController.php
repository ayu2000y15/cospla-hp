<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Image;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Models\Tag;

class NewsController extends Controller
{
    public function index()
    {
        $topImg = Image::where('VIEW_FLG', 'S103')->active()->visible()->first();
        $backImg = Image::where('VIEW_FLG', 'S003')->active()->visible()->first();
        $logoImg = Image::where('VIEW_FLG', 'S999')->active()->visible()->first();
        $previewImg = Image::where('VIEW_FLG', 'S998')->active()->visible()->first();

        $sns = Company::first();

        // すべてのニュースを投稿日の降順で取得（tags は SORT_ORDER 順で取得）
        $newsItems = News::with(['tags' => function ($q) {
            $q->orderBy('SORT_ORDER');
        }])->where('published_status', true)->orderBy('POST_DATE', 'desc')->orderBy('NEWS_ID', 'desc')->get();

        return view('news.index', compact('newsItems', 'topImg', 'backImg', 'logoImg', 'previewImg', 'sns'));
    }

    public function show($id)
    {
        $topImg = Image::where('VIEW_FLG', 'S103')->active()->visible()->first();
        $backImg = Image::where('VIEW_FLG', 'S003')->active()->visible()->first();
        $logoImg = Image::where('VIEW_FLG', 'S999')->active()->visible()->first();
        $sns = Company::first();

        // 画像はそのまま、タグは SORT_ORDER 順で取得する
        $newsItem = News::with(['images', 'tags' => function ($q) {
            $q->orderBy('SORT_ORDER');
        }])->where('published_status', true)->findOrFail($id);

        // --- ここからが追加・変更箇所 ---
        $videoExtensions = ['mp4', 'mov', 'webm'];

        // ニュースに紐づくメディア情報を加工して、ビューで使いやすい形式に変換する
        $mediaItems = $newsItem->images->map(function ($image) use ($videoExtensions) {
            $extension = strtolower(pathinfo($image->FILE_NAME, PATHINFO_EXTENSION));
            return [
                'src' => asset($image->FILE_PATH . $image->FILE_NAME),
                'alt' => $image->COMMENT,
                'isVideo' => in_array($extension, $videoExtensions),
            ];
        });
        // --- ここまでが追加・変更箇所 ---

        // 加工済みの $mediaItems をビューに渡す
        return view('news.show', compact('newsItem', 'topImg', 'backImg', 'logoImg', 'sns', 'mediaItems'));
    }
}
