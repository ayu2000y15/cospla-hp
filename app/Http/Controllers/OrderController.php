<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Company;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $topImg = Image::where('VIEW_FLG', 'S104')->active()->visible()->first();
        $cosplayImg1 = Image::where('VIEW_FLG', 'S401')->active()->visible()->get();
        $cosplayImg2 = Image::where('VIEW_FLG', 'S402')->active()->visible()->get();
        $backImg = Image::where('VIEW_FLG', 'S004')->active()->visible()->first();
        $logoImg = Image::where('VIEW_FLG', 'S999')->active()->visible()->first();
        $sns = Company::first();

        // 返すビューを 'order' に変更
        return view('order', compact('topImg', 'cosplayImg1', 'cosplayImg2', 'backImg', 'logoImg', 'sns'));
    }
}
