<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostumeClientImage extends Model
{
    use HasFactory;

    protected $primaryKey = 'image_id';

    protected $fillable = [
        'client_id',
        'file_path',
        'file_name',
        'alt_text',
        'priority',
    ];

    /**
     * この画像が属するクライアントを取得
     */
    public function client()
    {
        return $this->belongsTo(CostumeClient::class, 'client_id', 'client_id');
    }
}
