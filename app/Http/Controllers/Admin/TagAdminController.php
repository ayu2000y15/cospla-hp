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
        return view('admin', compact('tagList'));
    }

    public function store(Request $request)
    {
        Tag::create($request->all());
        return redirect()->route('admin')
        ->with('message', '新しいタグが追加されました。')
        ->with('activeTab', 'tag-entry');
    }

    public function delete($id)
    {
        Tag::destroy($id);
        return redirect()->route('admin')
        ->with('message', 'タグが削除されました。')
        ->with('activeTab', 'tag-entry');
    }
}