<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TalentInfoControl extends Model
{
    protected $table = 'talent_info_controls';
    protected $primaryKey = 'TALENT_ID';
    public $timestamps = false;

    protected $fillable = [
        'TALENT_ID', 'FOLLOWERS_FLG', 'HEIGHT_FLG', 'AGE_FLG', 'BIRTHDAY_FLG',
        'THREE_SIZES_FLG', 'THREE_SIZES_B_FLG', 'THREE_SIZES_W_FLG', 'THREE_SIZES_H_FLG',
        'HOBBY_SPECIALTY_FLG', 'COMMENT_FLG', 'SNS_1_FLG', 'SNS_2_FLG', 'SNS_3_FLG',
        'SPARE1', 'SPARE2'
    ];

    public function talent()
    {
        return $this->belongsTo(Talent::class, 'TALENT_ID', 'TALENT_ID');
    }
}