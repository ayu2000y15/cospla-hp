<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Talent;
use App\Models\News;
use App\Models\Image;
use App\Models\Tag;
use App\Services\FileUploadService;

class AdminController extends Controller
{
    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function index()
    {
        $talentList = Talent::all()->sortByDesc('TALENT_ID');
        $newsList = News::all()->sortByDesc('POST_DATE');
        $imgList = Image::where('TALENT_ID', null)->get();
        $talentImgList = Image::whereNotNull('TALENT_ID')->get();
        $viewFlags = Image::select('VIEW_FLG', 'COMMENT')->distinct()->get();
        $tagList = Tag::all()->sortBy('TAG_ID');

        $activeTab = request('active_tab', 'talent-list');
        $logoImg = Image::where('VIEW_FLG', 'S999')->active()->visible()->first();

        return view('admin.index', compact('talentList'
        ,'newsList'
        ,'imgList'
        ,'talentImgList'
        ,'viewFlags'
        ,'tagList'
        ,'activeTab'
        ,'logoImg'
        ));
    }
}