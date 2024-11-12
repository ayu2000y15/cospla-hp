<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\News;
use App\Models\Talent;
use App\Models\Company;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $talent = Image::where('VIEW_FLG', '01')->active()->visible()->whereRaw('PRIORITY > 0')->orderBy('PRIORITY')->take(4)->get();
        $cosplay = Image::where('VIEW_FLG', 'S203')->active()->visible()->orderBy('PRIORITY')->take(6)->get();
        $slides = Image::where('VIEW_FLG', 'S201')->active()->visible()->get();
        $slidesCnt = $slides->count();
        $newsTitle = News::active()->orderBy('POST_DATE', 'desc')->take(5)->get();

        $topImg = Image::where('VIEW_FLG', 'S204')->active()->visible()->get();
        $backImg = Image::where('VIEW_FLG', 'S001')->active()->visible()->first();
        $logoImg = Image::where('VIEW_FLG', 'S999')->active()->visible()->first();
        $sns = Company::first();

        return view('home', compact('talent', 'cosplay', 'slides', 'slidesCnt', 'newsTitle', 'topImg', 'backImg', 'logoImg','sns'));
    }
}