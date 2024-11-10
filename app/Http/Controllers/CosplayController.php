<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;


class CosplayController extends Controller
{
    public function index()
    {
        $topImg = Image::where('VIEW_FLG', 'S104')->active()->visible()->first();
        $cosplayImg1 = Image::where('VIEW_FLG', 'S401')->active()->visible()->get();
        $cosplayImg2 = Image::where('VIEW_FLG', 'S402')->active()->visible()->get();
        $backImg = Image::where('VIEW_FLG', 'S004')->active()->visible()->first();
        $logoImg = Image::where('VIEW_FLG', 'S999')->active()->visible()->first();

        return view('cosplay', compact('topImg', 'cosplayImg1', 'cosplayImg2', 'backImg', 'logoImg'));
    }
}