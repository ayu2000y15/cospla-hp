<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Company;
use Illuminate\Http\Request;


class AboutController extends Controller
{
    public function index()
    {
        $topImg = Image::where('VIEW_FLG', 'S102')->active()->visible()->first();
        $company = Company::all();
        $aboutImg = Image::where('VIEW_FLG', 'S301')->active()->visible()->get();
        $backImg = Image::where('VIEW_FLG', 'S002')->active()->visible()->first();
        $logoImg = Image::where('VIEW_FLG', 'S999')->active()->visible()->first();

        return view('about', compact('topImg', 'company', 'aboutImg', 'backImg', 'logoImg'));
    }
}