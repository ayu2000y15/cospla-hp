<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Models\Talent;
use App\Models\News;
use App\Models\Image;
use App\Models\Tag;
use App\Models\ViewFlag;
use App\Models\CareerCategory;
use App\Services\FileUploadService;
use Illuminate\Support\Facades\Session;
class AdminController extends Controller
{
    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function index()
    {
        //タレント一覧
        $talentList = Talent::all()->sortByDesc('TALENT_ID');
        //タグ登録・削除
        $tagList = Tag::all()->sortBy('TAG_ID');
        //経歴カテゴリ登録・削除
        $careerList = CareerCategory::all()->sortBy('CAREER_CATEGORY_ID');
        //ニュース登録・変更
        $newsList = News::all()->sortByDesc('POST_DATE');
        //HP画像登録・変更
        $imgList = Image::where('TALENT_ID', null)->get()->sortBy('VIEW_FLG');
        $talentImgList = Image::whereNotNull('TALENT_ID')
        ->where('VIEW_FLG', '=', '01')
        ->get()->sortBy('PRIORITY')->sortBy('TALENT_ID');
        $viewFlags = ViewFlag::select('VIEW_FLG', 'COMMENT')
        ->where('VIEW_FLG', 'like', 'S%')
        ->orWhere('VIEW_FLG', '=', '00')->distinct()->get();
        $viewFlagsBulk = ViewFlag::select('VIEW_FLG', 'COMMENT')
        ->where('MAX_COUNT', '<>', 1)
        ->where('VIEW_FLG', 'like', 'S%')
        ->orWhere('VIEW_FLG', '=', '00')
        ->distinct()->get();
        //会社情報
        $company = Company::all()->first();

        //ロゴ
        $logoImg = Image::where('VIEW_FLG', 'S999')->active()->visible()->first();

        if (!Session::has('activeTab')) {
            session()->flash('activeTab', 'talent-list');
        }
        
        return view('admin.index', compact('talentList'
        ,'newsList'
        ,'imgList'
        ,'talentImgList'
        ,'viewFlags'
        ,'viewFlagsBulk'
        ,'tagList'
        ,'careerList'
        ,'company'
        ,'logoImg'
        ));
    }
}