<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $topImg = Image::where('VIEW_FLG', 'S105')->active()->visible()->first();
        $backImg = Image::where('VIEW_FLG', 'S005')->active()->visible()->first();
        $logoImg = Image::where('VIEW_FLG', 'S999')->active()->visible()->first();

        return view('contact', compact('topImg', 'backImg', 'logoImg'));
    }

    public function submit(Request $request)
    {
        $validatedData = $request->validate([
            'inquiry_type' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'tel' => 'nullable',
            'subject' => 'required',
            'content' => 'required',
        ]);

        // ここでContactモデルを作成し、データを保存する処理を追加する必要があります。
        // 例: Contact::create($validatedData);

        return redirect()->route('contact.ok');
    }

    public function ok()
    {
        $topImg = Image::where('VIEW_FLG', 'S105')->active()->visible()->first();
        $backImg = Image::where('VIEW_FLG', 'S005')->active()->visible()->first();
        $logoImg = Image::where('VIEW_FLG', 'LOGO')->active()->visible()->first();

        return view('contact.ok', compact('topImg', 'backImg', 'logoImg'));
    }
}