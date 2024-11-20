<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Talent;
use App\Models\TalentInfoControl;
use App\Models\Image;
use App\Models\Tag;
use App\Models\CareerCategory;
use App\Models\TalentCareer;
use App\Models\TalentTag;
use App\Models\ViewFlag;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Services\FileUploadService;


class TalentAdminController extends Controller
{
    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }
    public function list()
    {
        $talentList = Talent::all()->sortByDesc('TALENT_ID');
        return view('admin', compact('talentList'));
    }

    public function delete(Request $request)
    {
        Talent::where('TALENT_ID', $request->TALENT_ID)->delete();
        session()->flash('activeTab', 'talent-list');
        return redirect()->route('admin')
        ->with('message', 'タレントが削除されました。');

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

        if($request->BIRTHDAY_FLG == '2'){
            $talentInfo['AGE'] = null;
            $request->AGE_FLG = '0';
        }

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
        ->with('message', 'タレントが登録されました');
    }

    public function talentAdmin(){
        $talentId = Session::get('talentId');
        //タレント情報
        $talent = Talent::findOrFail($talentId);
        $talentInfo = TalentInfoControl::findOrFail($talentId);

        //タレント写真情報
        $talentImgList = Image::where('TALENT_ID',$talentId)
        ->orderBy('VIEW_FLG')
        ->orderByRaw('PRIORITY is null')
        ->orderByRaw('PRIORITY = 0')
        ->orderBy('PRIORITY')
        ->get();
        $viewFlags = ViewFlag::select('VIEW_FLG', 'COMMENT')
        ->where('VIEW_FLG', 'like', '__')
        ->orWhere('VIEW_FLG', '=', '00')->distinct()->get();
        $viewFlagsBulk = ViewFlag::select('VIEW_FLG', 'COMMENT')
        ->where('MAX_COUNT', '<>', 1)
        ->where('VIEW_FLG', 'like', '__')
        ->orWhere('VIEW_FLG', '=', '00')
        ->distinct()->get();

        //タレント経歴
        //タレントが持っている経歴ジャンル
        $careerCategories = CareerCategory::all()->sortBy('CAREER_CATEGORY_ID');

        //タレント経歴
        $talentCareer = DB::table('talent_careers as tc')
        ->select(
            'tc.CAREER_ID as CAREER_ID',
            'tc.TALENT_ID as TALENT_ID',
            'tc.CONTENT as CONTENT',
            'tc.DETAIL as DETAIL',
            'tc.SPARE1 as SPARE1',
            'tc.ACTIVE_DATE as ACTIVE_DATE',
            'cc.CAREER_CATEGORY_ID as CAREER_CATEGORY_ID',
            'cc.CAREER_CATEGORY_NAME as CAREER_CATEGORY_NAME'
        )
        ->join('career_categories as cc','tc.CAREER_CATEGORY_ID','=','cc.CAREER_CATEGORY_ID')
        ->where('tc.TALENT_ID', $talentId)
        ->orderByRaw('tc.SPARE1 is null')
        ->orderByRaw('tc.SPARE1 = 0')
        ->orderByRaw('LENGTH(tc.SPARE1), tc.SPARE1')
        ->orderBy('tc.ACTIVE_DATE')
        ->orderBy('tc.CAREER_ID')
        ->get();

        //タレントタグ情報
        //タレントが持っているタグリスト
        $tagList =DB::table('talent_tags as tt')
        ->select(
            't.TAG_ID as TAG_ID',
            't.TAG_NAME as TAG_NAME',
            't.TAG_COLOR as TAG_COLOR'
        )
        ->join('tags as t','t.TAG_ID','=','tt.TAG_ID')
        ->where('tt.TALENT_ID', $talentId)
        ->orderBy('t.TAG_ID')
        ->get();

        $tagItem = null;
        $i = 0;
        foreach ($tagList as $tag) {
            $tagItem[] = $tag->TAG_ID;
            $i++;
        }

        //タレントが持っていないタグリスト（プルダウンで使用）
        $tagNotList = DB::table('tags as t')
        ->select(
            't.TAG_ID as TAG_ID',
            't.TAG_NAME as TAG_NAME'
        )
        ->whereNotIn('t.TAG_ID',  $tagItem)
        ->orderBy('t.TAG_ID')
        ->get();

        //ロゴ
        $logoImg = Image::where('VIEW_FLG', 'S999')->active()->visible()->first();
        if (!Session::has('activeTabT')) {
            session()->flash('activeTabT', 'talent-edit');
        }
        return view('admin.talent.talent-admin', 
        compact('talent'
        ,'talentInfo'
        , 'talentImgList'
        , 'viewFlags'
        , 'viewFlagsBulk'
        , 'careerCategories'
        , 'talentCareer'
        , 'tagList'
        , 'tagNotList'
        , 'logoImg'));

    }
    public function detail(Request $request)
    {
        Session::put('talentId', $request->TALENT_ID);
        return redirect()->route('admin.talent.admin');
    }

    //タレントの公開、非公開を一括変更
    public function bulkUpdateTalent(Request $request)
    {
        foreach($request->TALENT_PUBLIC as $talentId){
            $talent = TALENT::where('TALENT_ID', $talentId);
            $talent->update([
                'SPARE1' => $request->PUBLIC_FLG
            ]);
        }
        return redirect()->route('admin')
        ->with('message', 'タレントの公開設定が変更されました。')
        ->with('activeTabT', 'talent-list');
    }

    // タレント情報編集画面を表示
    public function edit(Request $request)
    {
        $talent = Talent::where('TALENT_ID', $request->TALENT_ID)->first();
        $talentInfoCtl = TalentInfoControl::where('TALENT_ID', $request->TALENT_ID)->first();
        $retirementDate = '2099-01-01';
        $delFlg = '0';
        if($request->RETIREMENT_DATE <> null){
            $retirementDate = $request->RETIREMENT_DATE;
            $delFlg = '1';
        }
        if($request->BIRTHDAY_FLG == '2'){
            $request->AGE = null;
            $request->AGE_FLG = '0';
        }
        $talent->update([
            'TALENT_ID'            => $request->TALENT_ID,
            'TALENT_NAME'          => $request->TALENT_NAME,
            'TALENT_FURIGANA_JP'   => $request->TALENT_FURIGANA_JP,
            'TALENT_FURIGANA_EN'   => $request->TALENT_FURIGANA_EN,
            'LAYER_NAME'           => $request->LAYER_NAME,
            'LAYER_FURIGANA_JP'    => $request->LAYER_FURIGANA_JP,
            'LAYER_FURIGANA_EN'    => $request->LAYER_FURIGANA_EN,
            'FOLLOWERS'            => $request->FOLLOWERS,
            'STREAM_FLG'           => $request->STREAM_FLG,
            'COS_FLG'              => $request->COS_FLG,
            'HEIGHT'               => $request->HEIGHT,
            'AGE'                  => $request->AGE,
            'BIRTHDAY'             => $request->BIRTHDAY,
            'THREE_SIZES_B'        => $request->THREE_SIZES_B,
            'THREE_SIZES_W'        => $request->THREE_SIZES_W,
            'THREE_SIZES_H'        => $request->THREE_SIZES_H,
            'HOBBY_SPECIALTY'      => $request->HOBBY_SPECIALTY,
            'COMMENT'              => $request->COMMENT,
            'AFFILIATION_DATE'     => $request->AFFILIATION_DATE,
            'RETIREMENT_DATE'      => $retirementDate,
            'MAIL'                 => $request->MAIL,
            'TEL_NO'               => $request->TEL_NO,
            'SNS_1'                => $request->SNS_1,
            'SNS_2'                => $request->SNS_2,
            'SNS_3'                => $request->SNS_3,
            'DEL_FLG'              => $delFlg
        ]);

        $threeSizeFlg = '0';
        if($request->THREE_SIZES_B_FLG == '1' || $request->THREE_SIZES_W_FLG == '1' || $request->THREE_SIZES_H_FLG == '1'){
            $threeSizeFlg = '1';
        }
        //talent_info_controlsテーブルに登録
        $talentInfoCtl->update([
            'TALENT_ID'          =>  $request->TALENT_ID            ,
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

        //TalentTagテーブル更新
        TalentTag::where('TALENT_ID', $request->TALENT_ID)
        ->where('TAG_ID', '1')->delete();
        TalentTag::where('TALENT_ID', $request->TALENT_ID)
        ->where('TAG_ID', '2')->delete();
        if ($request->COS_FLG == '1' || $request->COS_FLG == '3') {
            $talent->tags()->attach(1);
        }
        if ($request->COS_FLG == '2' || $request->COS_FLG == '3') {
            $talent->tags()->attach(2);
        }

        Session::put('talentId', $request->TALENT_ID);
        session()->flash('activeTabT', 'talent-edit');
        return redirect()->route('admin.talent.admin')
        ->with('message', 'タレント情報が更新されました。');
    }

    // タレント写真をアップロード
    public function uploadPhotos(Request $request)
    {
        $uploadedFiles = $request->file('photos');
        $filePath = 'img/' . $request->TALENT_ID . '_' . $request->LAYER_NAME;

        $result = $this->fileUploadService->uploadFiles($uploadedFiles, $filePath, $request->TALENT_ID);
        session()->flash('activeTabT', 'talent-photos');
        if ($result['success']) {
            return redirect()->route('admin.talent.admin')
            ->with('message', 'ファイルが正常にアップロードされました。');
        } else {
            return redirect()->route('admin.talent.admin')
            ->with('error', 'ファイルのアップロードに失敗しました: ' . $result['message']);
        }
    }

    // タレント写真の表示設定を更新
    public function updatePhoto(Request $request)
    {
        $photo = Image::where('TALENT_ID', $request->TALENT_ID)
        ->where('FILE_NAME', $request->FILE_NAME);

        $photo->update([
            'VIEW_FLG' => $request->VIEW_FLG,
            'PRIORITY' => $request->PRIORITY
        ]);

        session()->flash('activeTabT', 'talent-photos');
        return redirect()->route('admin.talent.admin' )
        ->with('message', '写真の表示設定が更新されました。');
    }

    // タレント写真を削除
    public function deletePhoto(Request $request)
    {
        $img = Image::where('TALENT_ID', $request->TALENT_ID)
        ->where('FILE_NAME', $request->FILE_NAME)->first();
        session()->flash('activeTabT', 'talent-photos');

        if ($img) {
            $this->fileUploadService->deleteFile($img->FILE_PATH . $img->FILE_NAME);
            $img->delete();
            return redirect()->route('admin.talent.admin')
            ->with('message', '写真が削除されました。');
        }

        return redirect()->route('admin.talent.admin')
        ->with('message', '写真の削除に失敗しました。');
    }

    //タレント写真を一括変更
    public function bulkUpdatePhoto(Request $request)
    {
        foreach($request->SELECTED_PHOTOS as $photo){
            $img = Image::where('FILE_NAME', $photo);
            $img->update([
                'VIEW_FLG' => $request->BULK_VIEW_FLG,
                'PRIORITY' => $request->PRIORITY
            ]);
        }
        return redirect()->route('admin.talent.admin')
        ->with('message', '写真の表示設定が変更されました。')
        ->with('activeTabT', 'talent-photos');
    }

    // タレント経歴を追加
    public function storeCareer(Request $request)
    {
        $validatedData = $request->validate([
            'CAREER_CATEGORY_ID' => 'required|exists:career_categories,CAREER_CATEGORY_ID',
            'CONTENT' => 'required|string',
            'ACTIVE_DATE' => 'nullable|date',
            'SPARE1' => 'nullable|integer',
            'DETAIL' => 'nullable|string',
        ]);

        $talent = Talent::where('TALENT_ID', $request->TALENT_ID)->first();
        $talent->careers()->create($validatedData);
        session()->flash('activeTabT', 'talent-career');

        return redirect()->route('admin.talent.admin', $talent)
        ->with('message', '経歴が追加されました。');
    }

    // タレント経歴を更新
    public function updateCareer(Request $request)
    {
        $validatedData = $request->validate([
            'CAREER_CATEGORY_ID' => 'required|exists:career_categories,CAREER_CATEGORY_ID',
            'CONTENT' => 'required|string',
            'ACTIVE_DATE' => 'nullable|date',
            'SPARE1' => 'nullable|integer',
            'DETAIL' => 'nullable|string',
        ]);

        $career = TalentCareer::where('CAREER_ID', $request->CAREER_ID);
        $career->update($validatedData);

        session()->flash('activeTabT', 'talent-career');

        return redirect()->route('admin.talent.admin')
        ->with('message', '経歴が更新されました。');
    }

    // タレント経歴を削除
    public function deleteCareer(Request $request)
    {
        $career = TalentCareer::where('CAREER_ID', $request->CAREER_ID);
        $career->delete();

        session()->flash('activeTabT', 'talent-career');

        return redirect()->route('admin.talent.admin')
        ->with('message', '経歴が削除されました。');
    }

    // タレントにタグを追加
    public function addTag(Request $request)
    {
        $count = Tag::where('TAG_NAME', $request->TAG_NAME)->count();
        if($count > 0){
            return redirect()->route('admin.talent.admin')
            ->with('error', 'タグが既に登録されています。タグ名を変更してください。')
            ->with('activeTabT', 'talent-tag');
        }
        $talent = Talent::where('TALENT_ID', $request->TALENT_ID)->first();
        $talent->tags()->attach($request->TAG_ID);
        session()->flash('activeTabT', 'talent-tag');
        return redirect()->route('admin.talent.admin', $talent)
        ->with('message', 'タグが追加されました。');
    }

    // タレントからタグを削除
    public function deleteTag(Request $request)
    {
        $talent = Talent::where('TALENT_ID', $request->TALENT_ID)->first();
        $talent->tags()->detach($request->TAG_ID);
        session()->flash('activeTabT', 'talent-tag');
        return redirect()->route('admin.talent.admin', $talent)
        ->with('message', 'タグが削除されました。');
    }

    // タレント退職処理
    public function retire(Request $request)
    {
        $validatedData = $request->validate([
            'RETIREMENT_DATE' => 'required|date',
        ]);
        $talent = Talent::where('TALENT_ID', $request->TALENT_ID)->first();
        $talent->update([
            'RETIREMENT_DATE' => $validatedData['RETIREMENT_DATE'],
            'DEL_FLG' => '1'
        ]);
        session()->flash('activeTabT', 'talent-retire');
        return redirect()->route('admin.talent.admin', $talent)
        ->with('message', 'タレントの退職日が設定されました。');
    }
}