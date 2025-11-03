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
        // 並び順カラムがあればそれで並べる
        $tagList = Tag::orderBy('SORT_ORDER')->get();
        return view('admin', compact('tagList'));
    }

    public function store(Request $request)
    {
        $count = Tag::where('TAG_NAME', $request->TAG_NAME)->count();
        if ($count > 0) {
            return redirect()->route('admin', ['tab' => 'categories'])
                ->with('error', 'タグが既に登録されています。タグ名を変更してください。');
        }

        Tag::create($request->all());

        if (isset($request->TALENT_ID)) {
            return redirect()->route('admin.talent.admin')
                ->with('message', '新しいタグが追加されました。');
        }
        session()->flash('activeTabT', 'tag');

        return redirect()->route('admin', ['tab' => 'categories'])
            ->with('message', '新しいタグが追加されました。');
    }

    /**
     * タグの並び順を更新する
     * 期待する入力: { order: [TAG_ID, TAG_ID, ...] }
     */
    public function updateOrder(Request $request)
    {
        $data = $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer',
        ]);

        $order = $data['order'];

        foreach ($order as $index => $tagId) {
            // indexは0始まりのため、1を足すかそのままでも良い
            Tag::where('TAG_ID', $tagId)->update(['SORT_ORDER' => $index]);
        }

        return response()->json(['success' => true, 'message' => '並び順を保存しました。']);
    }

    public function delete($id)
    {
        $count = TalentTag::where('TAG_ID', $id)->count();
        if ($count > 0) {
            return redirect()->route('admin', ['tab' => 'categories'])
                ->with('error', 'タグが使用されています。削除できません。');
        }
        Tag::destroy($id);
        return redirect()->route('admin', ['tab' => 'categories'])
            ->with('message', 'タグが削除されました。');
    }

    /**
     * タグの色を更新する
     */
    public function updateColor(Request $request, Tag $tag)
    {
        $request->validate([
            'color' => 'required|string|regex:/^#[a-fA-F0-9]{6}$/',
        ]);

        $tag->TAG_COLOR = $request->input('color');
        $tag->save();

        return response()->json(['success' => true, 'message' => 'タグの色を更新しました。']);
    }
}
