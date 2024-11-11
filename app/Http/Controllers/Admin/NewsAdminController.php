<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;

class NewsAdminController extends Controller
{
    public function entry()
    {
        $newsList = News::all()->sortByDesc('POST_DATE');
        return view('admin.news.entry', compact('newsList'));
    }

    public function store(Request $request)
    {
        News::create($request->all());
        return redirect()->route('admin.news.entry')->with('message', 'ニュースが登録されました。');
    }

    public function update(Request $request, $id)
    {
        $news = News::findOrFail($id);
        $news->update($request->all());
        return redirect()->route('admin.news.entry')->with('message', 'ニュースが更新されました。');
    }

    public function delete($id)
    {
        News::destroy($id);
        return redirect()->route('admin.news.entry')->with('message', 'ニュースが削除されました。');
    }
}