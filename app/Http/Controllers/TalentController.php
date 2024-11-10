<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Talent;
use App\Models\CareerCategory;
use Illuminate\Http\Request;

class TalentController extends Controller
{
    public function index()
    {
        $talentImg = Talent::active()->with('images')->get();
        $topImg = Image::where('VIEW_FLG', 'S103')->active()->visible()->first();
        $backImg = Image::where('VIEW_FLG', 'S003')->active()->visible()->first();
        $logoImg = Image::where('VIEW_FLG', 'S999')->active()->visible()->first();

        return view('talent.index', compact('talentImg', 'topImg', 'backImg', 'logoImg'));
    }

    public function show($id)
    {
        $talent = Talent::active()->findOrFail($id);
        $talentProfile = $talent->infoControl;
        $talentImg = $talent->images()->active()->visible()->get();
        $talentTag = $talent->tags()->active()->get();
        $careerCategory = CareerCategory::active()->get();
        $talentCareer = $talent->careers()->active()->get();
        $topImg = Image::where('VIEW_FLG', 'S103')->active()->visible()->first();
        $backImg = Image::where('VIEW_FLG', 'S003')->active()->visible()->first();
        $logoImg = Image::where('VIEW_FLG', 'S999')->active()->visible()->first();

        return view('talent.show', compact('talent', 'talentProfile', 'talentImg', 'talentTag', 'careerCategory', 'talentCareer', 'topImg', 'backImg', 'logoImg'));
    }
}