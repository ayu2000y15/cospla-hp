<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';
    protected $primaryKey = 'TAG_ID';
    const CREATED_AT = 'INS_DATE';
    const UPDATED_AT = 'UPD_DATE';
    public $timestamps = true;

    protected $fillable = [
        'TAG_NAME',
        'TAG_COLOR',
        'SPARE1',
        'SPARE2',
        'DEL_FLG'
    ];

    protected $dates = ['INS_DATE', 'UPD_DATE'];

    public function talents()
    {
        return $this->belongsToMany(Talent::class, 'talent_tags', 'TAG_ID', 'TALENT_ID');
    }

    public function scopeActive($query)
    {
        return $query->where('DEL_FLG', '0');
    }

    /**
     * このタグが紐づくお知らせを取得
     */
    public function news()
    {
        return $this->belongsToMany(News::class, 'news_tags', 'tag_id', 'news_id');
    }
}
