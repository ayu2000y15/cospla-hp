<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news';
    protected $primaryKey = 'NEWS_ID';
    const CREATED_AT = 'INS_DATE';
    const UPDATED_AT = 'UPD_DATE';
    public $timestamps = true;

    protected $fillable = [
        'TITLE',
        'CONTENT',
        'POST_DATE',
        'SPARE1',
        'SPARE2',
        'DEL_FLG'
    ];

    protected $dates = ['POST_DATE', 'INS_DATE', 'UPD_DATE'];

    public function scopeActive($query)
    {
        return $query->where('DEL_FLG', '0');
    }

    /**
     * ★★★ このメソッドを追記 ★★★
     * このお知らせが所有するタグを取得
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'news_tags', 'news_id', 'tag_id');
    }

    /**
     * ニュースに紐づく画像・動画を取得するリレーション
     */
    public function images()
    {
        // VIEW_FLG 'S501' をニュース用のメディアとする
        return $this->hasMany(Image::class, 'NEWS_ID', 'NEWS_ID')->where('VIEW_FLG', 'S501');
    }
}
