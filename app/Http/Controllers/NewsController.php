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
        $sns = Company::first();

        // すべてのニュースを投稿日の降順で取得
        $newsItems = News::orderBy('post_date', 'desc')->get();

        return view('news.index', compact('newsItems', 'topImg', 'backImg', 'logoImg', 'sns'));
    }

    public function show($id)
    {
        $topImg = Image::where('VIEW_FLG', 'S103')->active()->visible()->first();
        $backImg = Image::where('VIEW_FLG', 'S003')->active()->visible()->first();
        $logoImg = Image::where('VIEW_FLG', 'S999')->active()->visible()->first();
        $sns = Company::first();

        $newsItem = News::findOrFail($id);
        $newsImgList = Image::where('VIEW_FLG',  'S501')->orderBy('NEWS_ID')->get();

        return view('news.show', compact('newsItem', 'topImg', 'backImg', 'logoImg', 'sns', 'newsImgList'));
    }
}
