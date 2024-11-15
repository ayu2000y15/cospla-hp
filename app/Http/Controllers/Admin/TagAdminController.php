<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\TalentTag;

use Illuminate\Support\Facades\Session;

class TagAdminController extends Controller
{
    public function entry()
    {
        $tagList = Tag::all()->sortBy('TAG_ID');
        return view('admin', compact('tagList'));
    }

    public function store(Request $request)
    {
        $count = Tag::where('TAG_NAME', $request->TAG_NAME)->count();
        if($count > 0){
            return redirect()->route('admin')
            ->with('error', 'タグが既に登録されています。タグ名を変更してください。')
            ->with('activeTab', 'tag-entry');
        }

        Tag::create($request->all());

        if (isset($request->TALENT_ID)) {
            return redirect()->route('admin.talent.admin')
        ->with('message', '新しいタグが追加されました。')
        ->with('activeTabT', 'talent-tag');
        }

        return redirect()->route('admin')
        ->with('message', '新しいタグが追加されました。')
        ->with('activeTab', 'tag-entry');
    }

    public function delete($id)
    {
        $count = TalentTag::where('TAG_ID', $id)->count();
        if($count > 0){
            return redirect()->route('admin')
            ->with('error', 'タグが使用されています。削除できません。')
            ->with('activeTab', 'tag-entry');
        }
        Tag::destroy($id);
        return redirect()->route('admin')
        ->with('message', 'タグが削除されました。')
        ->with('activeTab', 'tag-entry');
    }
}