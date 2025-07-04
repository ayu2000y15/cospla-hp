<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TalentCareer extends Model
{
    protected $table = 'talent_careers';
    protected $primaryKey = 'CAREER_ID';
    const CREATED_AT = 'INS_DATE';
    const UPDATED_AT = 'UPD_DATE';
    public $timestamps = true;

    protected $fillable = [
        'TALENT_ID',
        'CAREER_CATEGORY_ID',
        'CONTENT',
        'DETAIL',
        'ACTIVE_DATE',
        'SPARE1',
        'SPARE2',
        'DEL_FLG'
    ];

    /**
     * ★★★ 修正点 ★★★
     * $dates プロパティの代わりに、$casts プロパティを使用して
     * 日付として扱うカラムを明示的に定義します。
     * これにより、NULL値や日付フォーマットが正しく処理されるようになります。
     *
     * @var array
     */
    protected $casts = [
        'ACTIVE_DATE' => 'date',
        'INS_DATE' => 'datetime',
        'UPD_DATE' => 'datetime',
    ];

    public function talent()
    {
        return $this->belongsTo(Talent::class, 'TALENT_ID', 'TALENT_ID');
    }

    public function category()
    {
        return $this->belongsTo(CareerCategory::class, 'CAREER_CATEGORY_ID', 'CAREER_CATEGORY_ID');
    }

    public function scopeActive($query)
    {
        return $query->where('DEL_FLG', '0');
    }
}
