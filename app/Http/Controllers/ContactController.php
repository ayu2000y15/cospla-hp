<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Company;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $topImg = Image::where('VIEW_FLG', 'S105')->active()->visible()->first();
        $backImg = Image::where('VIEW_FLG', 'S005')->active()->visible()->first();
        $logoImg = Image::where('VIEW_FLG', 'S999')->active()->visible()->first();
        $sns = Company::first();

        return view('contact', compact('topImg', 'backImg', 'logoImg','sns'));
    }

    public function ok(Request $request)
    {
        //入力されたメールに返信する

        return redirect()->route('contact')
        ->with('message', 'フォームが送信されました。返答をお待ちください。');
        }
}