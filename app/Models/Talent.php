<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Talent extends Model
{
    protected $table = 'talents';
    protected $primaryKey = 'TALENT_ID';
    const CREATED_AT = 'INS_DATE';
    const UPDATED_AT = 'UPD_DATE';
    public $timestamps = true;

    protected $fillable = [
        'TALENT_NAME',
        'TALENT_FURIGANA_JP',
        'TALENT_FURIGANA_EN',
        'LAYER_NAME',
        'LAYER_FURIGANA_JP',
        'LAYER_FURIGANA_EN',
        'FOLLOWERS',
        'STREAM_FLG',
        'COS_FLG',
        'HEIGHT',
        'AGE',
        'BIRTHDAY',
        'THREE_SIZES_B',
        'THREE_SIZES_W',
        'THREE_SIZES_H',
        'HOBBY_SPECIALTY',
        'COMMENT',
        'AFFILIATION_DATE',
        'RETIREMENT_DATE',
        'MAIL',
        'TEL_NO',
        'SNS_1',
        'SNS_2',
        'SNS_3',
        'SPARE1',
        'SPARE2',
        'SPARE3',
        'PRIORITY',
        'CONTRACT_TYPE',
        'DEL_FLG'
    ];

    /**
     * 日付として扱う属性を定義します。
     * Laravelが自動的にCarbonオブジェクトに変換してくれます。
     *
     * @var array
     */
    protected $casts = [
        'BIRTHDAY' => 'date',
        'AFFILIATION_DATE' => 'date',
        'RETIREMENT_DATE' => 'date',
        'INS_DATE' => 'datetime',
        'UPD_DATE' => 'datetime',
    ];

    public function careers()
    {
        return $this->hasMany(TalentCareer::class, 'TALENT_ID', 'TALENT_ID');
    }

    public function infoControl()
    {
        return $this->hasOne(TalentInfoControl::class, 'TALENT_ID', 'TALENT_ID');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'talent_tags', 'TALENT_ID', 'TAG_ID');
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'TALENT_ID', 'TALENT_ID');
    }

    public function scopeActive($query)
    {
        return $query->where('DEL_FLG', '0')->where('RETIREMENT_DATE', '>', now())->where('SPARE1', '1');
    }

    /**
     * タレントに紐づく経歴カテゴリを取得する（並び順を考慮）
     */
    public function careerCategories()
    {
        return $this->belongsToMany(CareerCategory::class, 'talent_career_category_orders', 'talent_id', 'career_category_id')
            ->withPivot('priority')
            ->orderBy('priority');
    }
}
