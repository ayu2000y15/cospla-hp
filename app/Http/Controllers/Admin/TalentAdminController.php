<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Talent;
use App\Models\TalentInfoControl;
use App\Models\Image;

class TalentAdminController extends Controller
{
    public function list()
    {
        $talentList = Talent::all()->sortByDesc('TALENT_ID');
        return view('admin', compact('talentList'));
    }

    public function entry()
    {
        return view('admin');
    }

    public function store(Request $request)
    {
        $talentInfo = $request->only([
            'TALENT_NAME', 'TALENT_FURIGANA_JP', 'TALENT_FURIGANA_EN',
            'LAYER_NAME', 'LAYER_FURIGANA_JP', 'LAYER_FURIGANA_EN',
            'FOLLOWERS', 'STREAM_FLG', 'COS_FLG', 'HEIGHT', 'AGE',
            'BIRTHDAY', 'THREE_SIZES_B', 'THREE_SIZES_W', 'THREE_SIZES_H',
            'HOBBY_SPECIALTY', 'COMMENT', 'AFFILIATION_DATE', 'MAIL',
            'TEL_NO', 'SNS_1', 'SNS_2', 'SNS_3'
        ]);

        //talentsテーブルに登録
        $talent = Talent::create($talentInfo);
        $talentId = Talent::select('TALENT_ID')->max('TALENT_ID');
        $threeSizeFlg = '0';
        if($request->THREE_SIZES_B_FLG == '1' || $request->THREE_SIZES_W_FLG == '1' || $request->THREE_SIZES_H_FLG == '1'){
            $threeSizeFlg = '1';
        }
        //talent_info_controlsテーブルに登録
        TalentInfoControl::create([
            'TALENT_ID'          =>  $talentId                      ,
            'FOLLOWERS_FLG'      =>  $request->FOLLOWERS_FLG        ,
            'HEIGHT_FLG'         =>  $request->HEIGHT_FLG           ,
            'AGE_FLG'            =>  $request->AGE_FLG              ,
            'BIRTHDAY_FLG'       =>  $request->BIRTHDAY_FLG         ,
            'THREE_SIZES_FLG'    =>  $threeSizeFlg                  ,
            'THREE_SIZES_B_FLG'  =>  $request->THREE_SIZES_B_FLG    ,
            'THREE_SIZES_W_FLG'  =>  $request->THREE_SIZES_W_FLG    ,
            'THREE_SIZES_H_FLG'  =>  $request->THREE_SIZES_H_FLG    ,
            'HOBBY_SPECIALTY_FLG'=>  $request->HOBBY_SPECIALTY_FLG  ,
            'COMMENT_FLG'        =>  $request->COMMENT_FLG          ,
            'SNS_1_FLG'          =>  $request->SNS_1_FLG            ,
            'SNS_2_FLG'          =>  $request->SNS_2_FLG            ,
            'SNS_3_FLG'          =>  $request->SNS_3_FLG
        ]);

        if ($request->COS_FLG == '1' || $request->COS_FLG == '3') {
            $talent->tags()->attach(1);
        }
        if ($request->COS_FLG == '2' || $request->COS_FLG == '3') {
            $talent->tags()->attach(2);
        }

        return redirect()->route('admin')
        ->with('message', 'タレントが登録されました。タレント詳細ページで各種登録を行ってください。');
    }

    public function detail(Request $request)
    {
        $talent = Talent::findOrFail($request->TALENT_ID);
        $activeTab = request('active_tab', 'talent-edit');
        //ロゴ
        $logoImg = Image::where('VIEW_FLG', 'S999')->active()->visible()->first();

        return view('admin.talent.talent-admin', compact('talent', 'activeTab','logoImg'));
    }

    public function update(Request $request, $id)
    {
        $talent = Talent::findOrFail($id);
        $talent->update($request->all());
        $talent->infoCtl->update($request->all());

        // タグの更新処理
        $talent->tags()->detach();
        if ($request->COS_FLG == '1' || $request->COS_FLG == '3') {
            $talent->tags()->attach(1);
        }
        if ($request->COS_FLG == '2' || $request->COS_FLG == '3') {
            $talent->tags()->attach(2);
        }

        return redirect()->route('admin.talent.detail', $id)->with('message', 'タレント情報が更新されました。');
    }

    public function retire(Request $request, $id)
    {
        $talent = Talent::findOrFail($id);
        $talent->update(['RETIREMENT_DATE' => $request->RETIREMENT_DATE, 'DEL_FLG' => '1']);
        return redirect()->route('admin.talent.list')->with('message', 'タレントの退職日を登録しました。');
    }
}