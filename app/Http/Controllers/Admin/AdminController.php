<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AccessControl;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Models\Talent;
use App\Models\News;
use App\Models\Image;
use App\Models\Tag;
use App\Models\ViewFlag;
use App\Models\CareerCategory;
use App\Models\ContactCategory;
use App\Models\Acmail;
use Illuminate\Support\Facades\DB;


use App\Services\FileUploadService;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function login()
    {
        $logoImg = Image::where('VIEW_FLG', 'S999')->active()->visible()->first();
        return view('admin.login', compact('logoImg'));
    }

    public function loginAccess(Request $request)
    {
        $user = User::where('name', '=', $request->name)
            ->where('password', '=', $request->password);

        if ($user->count() == 0) {
            return redirect()->route('login')
                ->with('error', 'ログインに失敗しました。IDかパスワードが間違っています。');
        }
        $user = $user->first();
        $root = AccessControl::select('access_view', 'access_root')->where('access_id', $user['access_id'])->first();
        Session::put('access_view', $root->access_view);
        return redirect()->route($root->access_root);
    }

    public function logout()
    {
        $logoImg = Image::where('VIEW_FLG', 'S999')->active()->visible()->first();
        Session::flush();
        return redirect()->route('login')
            ->with('error', 'ログアウトしました。再度ログインしてください');
    }

    public function index()
    {
        if (!Session::has('access_view')) {
            return redirect()->route('login')
                ->with('error', 'セッションがありません。ログインしなおしてください。');
        }
        $access_view = Session::get('access_view');
        //タレント一覧
        $talentList = Talent::orderBy('PRIORITY')->orderBy('LAYER_NAME')->get();
        //タグ登録・削除
        $tagList = Tag::all()->sortBy('TAG_ID');
        //経歴カテゴリ登録・削除
        $careerList = CareerCategory::all()->sortBy('CAREER_CATEGORY_ID');
        //問い合わせカテゴリ登録・削除
        $contactList = ContactCategory::all()->sortBy('CONTACT_CATEGORY_ID');
        //ニュース登録・変更
        $newsList = News::with('tags')->orderBy('POST_DATE', 'desc')->orderBy('NEWS_ID', 'desc')->get();
        $newsImgList = Image::whereRaw('NEWS_ID is not null')->orderBy('NEWS_ID')->orderBy('PRIORITY')->get();

        // $newsList = DB::table('news as n')
        // ->select(
        //     'n.NEWS_ID as NEWS_ID',
        //     't.TITLE as TITLE',
        //     't.CONTENT as CONTENT',
        //     't.POST_DATE as POST_DATE',
        //     'img.FILE_NAME as FILE_NAME',
        //     'img.FILE_PATH as FILE_PATH',
        //     'img.PRIORITY as PRIORITY',
        //     'img.COMMENT as COMMENT'
        // )
        // ->join('images as img','n.NEWS_ID','=','img.NEWS_ID')
        // ->orderBy('img.PRIORITY')
        // ->orderBy('n.POST_DATE')
        // ->orderBy('n.NEWS_ID')
        // ->get();

        //HP画像登録・変更
        if (!Session::has('imgList')) {
            $imgList = Image::where('TALENT_ID', null)
                ->orderBy('VIEW_FLG')
                ->orderByRaw('PRIORITY is null')
                ->orderByRaw('PRIORITY = 0')
                ->orderBy('PRIORITY')->get();
        } else {
            $imgList = Session::get('imgList');
        }

        if (!Session::has('activeBtn')) {
            Session::put('activeBtn', 'photo');
        }

        $talentImgList = Image::whereNotNull('TALENT_ID')
            ->where('VIEW_FLG', '=', '01')
            ->orderBy('VIEW_FLG')
            ->orderByRaw('PRIORITY is null')
            ->orderByRaw('PRIORITY = 0')
            ->orderBy('PRIORITY')
            ->orderBy('TALENT_ID')
            ->get();
        $viewFlags = ViewFlag::select('VIEW_FLG', 'COMMENT')
            ->where('VIEW_FLG', 'like', 'S%')
            ->orWhere('VIEW_FLG', '=', '00')->distinct()->get();
        $viewFlagsBulk = ViewFlag::select('VIEW_FLG', 'COMMENT')
            ->where('MAX_COUNT', '<>', 1)
            ->where('VIEW_FLG', 'like', 'S%')
            ->orWhere('VIEW_FLG', '=', '00')
            ->distinct()->orderBy('VIEW_FLG')->get();
        //会社情報
        $company = Company::all()->first();

        //ロゴ
        $logoImg = Image::where('VIEW_FLG', 'S999')->active()->visible()->first();

        if (!Session::has('activeTab')) {
            session()->flash('activeTab', 'talent-list');
        }

        if (!Session::has('activeTabAc')) {
            session()->flash('activeTabAc', 'ac-entry');
        }

        $acmail = Acmail::all()->sortByDesc('AC_ID');

        return view($access_view, compact(
            'talentList',
            'newsList',
            'newsImgList',
            'imgList',
            'talentImgList',
            'viewFlags',
            'viewFlagsBulk',
            'tagList',
            'careerList',
            'contactList',
            'company',
            'logoImg',
            'acmail'
        ));
    }

    public function indexGuest()
    {
        //ロゴ
        $logoImg = Image::where('VIEW_FLG', 'S999')->active()->visible()->first();
        $access_view = Session::get('access_view');
        if (!Session::has('activeTab')) {
            session()->flash('activeTab', 'talent-entry');
        }
        return view($access_view, compact(
            'logoImg'
        ));
    }

    public function indexAcMail()
    {
        //ロゴ
        $logoImg = Image::where('VIEW_FLG', 'S999')->active()->visible()->first();
        $access_view = Session::get('access_view');

        //Acmail一覧取得
        $acmail = Acmail::all()->sortByDesc('AC_ID');
        if (!Session::has('activeTabAc')) {
            session()->flash('activeTabAc', 'ac-entry');
        }

        return view($access_view, compact(
            'logoImg',
            'acmail'
        ));
    }
}
