<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Image;
use App\Models\Company;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $topImg = Image::where('VIEW_FLG', 'S103')->active()->visible()->first();
        $backImg = Image::where('VIEW_FLG','S003')->active()->visible()->first();
        $logoImg = Image::where('VIEW_FLG', 'S999')->active()->visible()->first();
        $sns = Company::first();

        $newsItems = News::orderBy('post_date', 'desc')->get();
        $newsImgList = Image::where('VIEW_FLG',  'S501')->orderBy('NEWS_ID')->get();

        return view('news.index', compact('newsItems','sns', 'newsImgList'));
    }

    public function show($id)
    {
        $topImg = Image::where('VIEW_FLG', 'S103')->active()->visible()->first();
        $backImg = Image::where('VIEW_FLG','S003')->active()->visible()->first();
        $logoImg = Image::where('VIEW_FLG', 'S999')->active()->visible()->first();
        $sns = Company::first();

        $newsItem = News::findOrFail($id);
        $newsImgList = Image::where('VIEW_FLG',  'S501')->orderBy('NEWS_ID')->get();

        return view('news.show', compact('newsItem', 'topImg', 'backImg', 'logoImg','sns', 'newsImgList'));
    }
}
