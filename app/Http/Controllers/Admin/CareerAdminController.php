<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CareerCategory;
use App\Models\TalentCareer;


class CareerAdminController extends Controller
{
    public function entry(Request $request)
    {
        $count = CareerCategory::where('CAREER_CATEGORY_NAME', $request->CAREER_CATEGORY_NAME)->count();
        if ($count > 0) {
            return redirect()->route('admin', ['tab' => 'categories'])
                ->with('error', '経歴カテゴリが既に登録されています。経歴カテゴリ名を変更してください。');
        }
        CareerCategory::create($request->all());

        return redirect()->route('admin', ['tab' => 'categories'])
            ->with('message', '経歴カテゴリが新しく登録されました。');
    }

    public function update(Request $request)
    {
        $count = CareerCategory::where('CAREER_CATEGORY_NAME', $request->CAREER_CATEGORY_NAME)->count();
        if ($count > 0) {
            return redirect()->route('admin', ['tab' => 'categories'])
                ->with('error', '経歴カテゴリが既に登録されています。経歴カテゴリ名を変更してください。');
        }
        CareerCategory::where('CAREER_CATEGORY_ID', $request->CAREER_CATEGORY_ID)
            ->update(["CAREER_CATEGORY_NAME" => $request->CAREER_CATEGORY_NAME]);

        return redirect()->route('admin', ['tab' => 'categories'])
            ->with('message', '経歴カテゴリ名が変更されました。');
    }

    public function delete(Request $request)
    {
        $count = TalentCareer::where('CAREER_CATEGORY_ID', $request->CAREER_CATEGORY_ID)->count();
        if ($count > 0) {
            return redirect()->route('admin', ['tab' => 'categories'])
                ->with('error', '経歴カテゴリが使用されています。削除できません。');
        }
        CareerCategory::where('CAREER_CATEGORY_ID', $request->CAREER_CATEGORY_ID)
            ->delete();
        return redirect()->route('admin', ['tab' => 'categories'])
            ->with('message', '経歴カテゴリが削除されました。');
    }
}
