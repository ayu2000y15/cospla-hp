<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactCategory;
use App\Models\Contact;


class ContactAdminController extends Controller
{
    public function entry(Request $request)
    {
        $count = ContactCategory::where('CONTACT_CATEGORY_NAME', $request->CONTACT_CATEGORY_NAME)->count();
        $countR = ContactCategory::where('REFERENCE_CODE', $request->REFERENCE_CODE)->count();

        if ($count > 0) {
            return redirect()->route('admin', ['tab' => 'categories'])
                ->with('error', '問い合わせカテゴリが既に登録されています。問い合わせカテゴリ名を変更してください。');
        }

        if ($countR > 0) {
            return redirect()->route('admin', ['tab' => 'categories'])
                ->with('error', '問い合わせコードが既に登録されています。問い合わせコードを変更してください。');
        }

        ContactCategory::create($request->all());

        return redirect()->route('admin', ['tab' => 'categories'])
            ->with('message', '問い合わせカテゴリが新しく登録されました。');
    }

    public function update(Request $request)
    {
        $count = ContactCategory::where('CONTACT_CATEGORY_NAME', $request->CONTACT_CATEGORY_NAME)->count();
        if ($count > 0) {
            return redirect()->route('admin', ['tab' => 'categories'])
                ->with('error', '問い合わせカテゴリが既に登録されています。問い合わせカテゴリ名を変更してください。');
        }
        ContactCategory::where('CONTACT_CATEGORY_ID', $request->CONTACT_CATEGORY_ID)
            ->update(["CONTACT_CATEGORY_NAME" => $request->CONTACT_CATEGORY_NAME]);

        return redirect()->route('admin', ['tab' => 'categories'])
            ->with('message', '問い合わせカテゴリ名が変更されました。');
    }

    public function delete(Request $request)
    {
        $count = Contact::where('CONTACT_CATEGORY_ID', $request->CONTACT_CATEGORY_ID)->count();
        if ($count > 0) {
            return redirect()->route('admin', ['tab' => 'categories'])
                ->with('error', '問い合わせカテゴリが使用されています。削除できません。');
        }
        ContactCategory::where('CONTACT_CATEGORY_ID', $request->CONTACT_CATEGORY_ID)
            ->delete();
        return redirect()->route('admin', ['tab' => 'categories'])
            ->with('message', '問い合わせカテゴリが削除されました。');
    }
}
