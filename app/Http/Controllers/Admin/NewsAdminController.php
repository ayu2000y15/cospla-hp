<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Image;

class NewsAdminController extends Controller
{
    public function entry()
    {
        $newsList = News::all()->sortByDesc('POST_DATE');
        session()->flash('activeTab', 'news-entry');
        return view('admin', compact('newsList'));
    }

    public function store(Request $request)
    {
        News::create($request->all());

        return redirect()->route('admin')
        ->with('message', 'ニュースが登録されました。')
        ->with('activeTab', 'news-entry');
    }

    public function update(Request $request, $id)
    {
        $news = News::findOrFail($id);
        $news->update($request->all());
        return redirect()->route('admin')
        ->with('message', 'ニュースが更新されました。')
        ->with('activeTab', 'news-entry');
    }

    public function delete($id)
    {
        News::destroy($id);
        return redirect()->route('admin')
        ->with('message', 'ニュースが削除されました。')
        ->with('activeTab', 'news-entry');
    }
}