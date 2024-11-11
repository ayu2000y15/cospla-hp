<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tag;

class TagAdminController extends Controller
{
    public function entry()
    {
        $tagList = Tag::all()->sortBy('TAG_ID');
        return view('admin.tag.entry', compact('tagList'));
    }

    public function store(Request $request)
    {
        Tag::create($request->all());
        return redirect()->route('admin.tag.entry')->with('message', '新しいタグが追加されました。');
    }

    public function delete($id)
    {
        Tag::destroy($id);
        return redirect()->route('admin.tag.entry')->with('message', 'タグが削除されました。');
    }
}