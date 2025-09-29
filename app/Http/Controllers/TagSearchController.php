<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Talent;
use App\Models\News;
use App\Models\Image;
use App\Models\Company;

class TagSearchController extends Controller
{
    /**
     * タグで検索し、関連するタレントとお知らせを表示する
     */
    public function search($tagName)
    {
        // 指定されたタグ名でタグを検索、見つからなければ404エラー
        $tag = Tag::where('TAG_NAME', $tagName)->firstOrFail();

        // タグに紐づく公開中のタレントを取得
        $talents = $tag->talents()
            ->where('talents.DEL_FLG', '0')
            ->where('talents.RETIREMENT_DATE', '>', now())
            // SPARE1がどちらのテーブルか明確にするため 'talents.SPARE1' と指定
            ->where('talents.SPARE1', '1')
            ->orderBy('talents.PRIORITY', 'asc')
            ->get();

        // タグに紐づくお知らせを新しい順に取得
        $news = $tag->news()->orderBy('POST_DATE', 'desc')->orderBy('NEWS_ID', 'desc')->get();

        // 共通のビューデータを取得
        $topImg = Image::where('VIEW_FLG', 'S103')->active()->visible()->first();
        $backImg = Image::where('VIEW_FLG', 'S003')->active()->visible()->first();
        $logoImg = Image::where('VIEW_FLG', 'S999')->active()->visible()->first();
        $previewImg = Image::where('VIEW_FLG', 'S998')->active()->visible()->first();

        $sns = Company::first();

        return view('tag-search', compact(
            'tag',
            'talents',
            'news',
            'topImg',
            'backImg',
            'logoImg',
            'sns',
            'previewImg'
        ));
    }
}
