<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Talent;
use App\Models\Company;
use App\Models\TalentCareer;
use App\Models\TalentInfoControl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TalentController extends Controller
{
    public function index()
    {
        $talentImg = DB::table('talents as t')
            ->select(
                't.LAYER_NAME',
                't.TALENT_ID',
                'img1.FILE_NAME as FILE_NAME1',
                'img1.FILE_PATH as FILE_PATH1',
                'img1.COMMENT as ALT1',
                'img2.FILE_NAME as FILE_NAME2',
                'img2.FILE_PATH as FILE_PATH2',
                'img2.COMMENT as ALT2'
            )
            ->join('images as img1', 't.TALENT_ID', '=', 'img1.TALENT_ID')
            ->join('images as img2', 't.TALENT_ID', '=', 'img2.TALENT_ID')
            ->where('img1.VIEW_FLG', '01')
            ->where('img2.VIEW_FLG', '02')
            ->where('t.DEL_FLG', '0')
            ->whereRaw('t.RETIREMENT_DATE > CURDATE()')
            ->where('t.SPARE1', '1')
            ->orderByRaw('img1.PRIORITY is null')
            ->orderByRaw('img1.PRIORITY = 0')
            ->orderBy('img1.PRIORITY')
            ->orderBy('t.LAYER_NAME')
            ->get();
        $topImg = Image::where('VIEW_FLG', 'S103')->active()->visible()->first();
        $backImg = Image::where('VIEW_FLG', 'S003')->active()->visible()->first();
        $logoImg = Image::where('VIEW_FLG', 'S999')->active()->visible()->first();
        $sns = Company::first();

        return view('talent.index', compact('talentImg', 'topImg', 'backImg', 'logoImg', 'sns'));
    }

    public function show(Request $request)
    {
        $talent = Talent::active()->findOrFail($request['id']);
        $talentProfile = TalentInfoControl::where('TALENT_ID', $request['id'])->get()->first();
        $talentImgTop = Image::where('VIEW_FLG', '01')->where('TALENT_ID', $request['id'])->active()->get()->first();
        $talentImg = Image::where('VIEW_FLG', '03')->where('TALENT_ID', $request['id'])
            ->orderByRaw('PRIORITY is null')
            ->orderByRaw('PRIORITY = 0')
            ->orderBy('PRIORITY')
            ->active()->get();
        $talentTag = DB::table('talent_tags as t')
            ->select(
                'tag.TAG_NAME as TAG_NAME',
                'tag.TAG_COLOR as TAG_COLOR'
            )
            ->join('tags as tag', 't.TAG_ID', '=', 'tag.TAG_ID')
            ->where('t.TALENT_ID', $request['id'])
            ->orderBy('tag.TAG_ID')
            ->get();
        $careerCategory = DB::table('talent_careers as tc')
            ->select(
                'c.CAREER_CATEGORY_NAME as CAREER_CATEGORY_NAME',
                'c.CAREER_CATEGORY_ID as CAREER_CATEGORY_ID'
            )
            ->join('career_categories as c', 'tc.CAREER_CATEGORY_ID', '=', 'c.CAREER_CATEGORY_ID')
            ->where('tc.TALENT_ID', $request['id'])
            ->groupBy('c.CAREER_CATEGORY_ID')
            ->groupBy('c.CAREER_CATEGORY_NAME')
            ->orderByRaw("c.CAREER_CATEGORY_ID = '0' ")
            ->orderBy('c.CAREER_CATEGORY_ID')
            ->get();
        $talentCareer = TalentCareer::where('TALENT_ID', $request['id'])
            // 1. SPARE1 (優先度) が NULL でないものを先に、昇順で並べる
            // 2. 次に ACTIVE_DATE (活動日) の降順で並べる
            ->orderByRaw('SPARE1 IS NULL, SPARE1 ASC')
            ->orderBy('ACTIVE_DATE', 'desc')
            ->get();
        $topImg = Image::where('VIEW_FLG', 'S103')->active()->visible()->first();
        $backImg = Image::where('VIEW_FLG', 'S003')->active()->visible()->first();
        $logoImg = Image::where('VIEW_FLG', 'S999')->active()->visible()->first();
        $sns = Company::first();

        return view('talent.profile', compact(
            'talent',
            'talentProfile',
            'talentImgTop',
            'talentImg',
            'talentTag',
            'careerCategory',
            'talentCareer',
            'topImg',
            'backImg',
            'logoImg',
            'sns'
        ));
    }
}
