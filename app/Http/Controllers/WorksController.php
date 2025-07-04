<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Company;
use App\Models\CostumeClient; // 追加
use Illuminate\Http\Request;

class WorksController extends Controller
{
    public function index()
    {
        $topImg = Image::where('VIEW_FLG', 'S104')->active()->visible()->first();
        $backImg = Image::where('VIEW_FLG', 'S004')->active()->visible()->first();
        $logoImg = Image::where('VIEW_FLG', 'S999')->active()->visible()->first();
        $sns = Company::first();

        // is_visibleがtrueのクライアントをpriority順で取得
        $clients = CostumeClient::where('is_visible', true)
            ->with('images') // 関連する画像も一緒に取得
            ->orderBy('priority', 'asc')
            ->get();

        // cosplayImg1, cosplayImg2 は不要になったため削除
        return view('works', compact('topImg', 'backImg', 'logoImg', 'sns', 'clients'));
    }
}
