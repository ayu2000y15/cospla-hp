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
        ->select('img.FILE_PATH as FILE_PATH',
            'img.FILE_NAME as FILE_NAME',
            'img.COMMENT as ALT',
            't.LAYER_NAME as LAYER_NAME'
        )
        ->join('talents as t', 't.TALENT_ID', '=', 'img.TALENT_ID')
        ->whereRaw('img.PRIORITY > 0')
        ->where('t.DEL_FLG', '0')
        ->whereRaw('t.RETIREMENT_DATE > CURDATE()')
        ->where('t.SPARE1', '1')
        ->orderBy('img.PRIORITY')
        ->take(4)->get();

        $cosplay = Image::where('VIEW_FLG', 'S203')->active()->visible()->orderBy('PRIORITY')->take(6)->get();
        $slides = Image::where('VIEW_FLG', 'S201')->active()->visible()->orderBy('PRIORITY')->get();
        $slidesCnt = $slides->count();
        $newsTitle = News::active()->orderBy('POST_DATE', 'desc')->take(5)->get();

        $topImg = Image::where('VIEW_FLG', 'S204')->active()->visible()->get();
        $backImg = Image::where('VIEW_FLG', 'S001')->active()->visible()->first();
        $logoImg = Image::where('VIEW_FLG', 'S999')->active()->visible()->first();
        $sns = Company::first();

        return view('home', compact('talent', 'cosplay', 'slides', 'slidesCnt', 'newsTitle', 'topImg', 'backImg', 'logoImg','sns'));
    }
}