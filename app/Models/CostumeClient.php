<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostumeClient extends Model
{
    use HasFactory;

    protected $primaryKey = 'client_id';

    protected $fillable = [
        'client_name',
        'client_name_kana',
        'description',
        'homepage_url',
        'sns_x',
        'sns_instagram',
        'sns_tiktok',
        'is_visible',
        'priority',
    ];

    /**
     * このクライアントに紐づく画像を取得
     */
    public function images()
    {
        // ★★★ orderByを追加 ★★★
        return $this->hasMany(CostumeClientImage::class, 'client_id', 'client_id')->orderBy('priority', 'asc');
    }
}
