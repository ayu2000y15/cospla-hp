<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\News;
use App\Models\Talent;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    public function index()
    {
        $talent = DB::table('images as img')
            ->select(
                'img.FILE_PATH as FILE_PATH',
                'img.FILE_NAME as FILE_NAME',
                'img.COMMENT as ALT',
                't.LAYER_NAME as LAYER_NAME',
                't.TALENT_ID as TALENT_ID'
            )
            ->join('talents as t', 't.TALENT_ID', '=', 'img.TALENT_ID')
            ->where('VIEW_FLG', '01')
            ->whereRaw('img.PRIORITY > 0')
            ->where('t.DEL_FLG', '0')
            ->whereRaw('t.RETIREMENT_DATE > CURDATE()')
            ->where('t.SPARE1', '1')
            ->orderBy('t.PRIORITY', 'asc')
            ->take(4)->get();

        $cosplay = Image::where('VIEW_FLG', 'S203')->active()->visible()
            ->orderByRaw('PRIORITY is null')
            ->orderByRaw('PRIORITY = 0')
            ->orderBy('PRIORITY')->take(6)->get();
        $slides = Image::where('VIEW_FLG', 'S201')->active()->visible()
            ->orderByRaw('PRIORITY is null')
            ->orderByRaw('PRIORITY = 0')
            ->orderBy('PRIORITY')->get();
        $slidesCnt = $slides->count();
        $newsTitle = News::active()->orderBy('POST_DATE', 'desc')->take(6)->get();

        $topImg = Image::where('VIEW_FLG', 'S204')->active()->visible()->get();
        $backImg = Image::where('VIEW_FLG', 'S001')->active()->visible()->first();
        $logoImg = Image::where('VIEW_FLG', 'S999')->active()->visible()->first();
        $previewImg = Image::where('VIEW_FLG', 'S998')->active()->visible()->first();

        $sns = Company::first();

        return view('home', compact('talent', 'cosplay', 'slides', 'slidesCnt', 'newsTitle', 'topImg', 'backImg', 'logoImg', 'sns', 'previewImg'));
    }

    public function privacyPolicy()
    {
        $topImg = Image::where('VIEW_FLG', 'S102')->active()->visible()->first();
        $backImg = Image::where('VIEW_FLG', 'S002')->active()->visible()->first();
        $logoImg = Image::where('VIEW_FLG', 'S999')->active()->visible()->first();
        $sns = Company::first();

        return view('privacy-policy', compact('topImg', 'backImg', 'logoImg', 'sns'));
    }
}
