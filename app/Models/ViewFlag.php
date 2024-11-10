<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewFlag extends Model
{
    /**
     * モデルに関連付けるテーブル
     *
     * @var string
     */
    protected $table = 'view_flags';

    /**
     * プライマリーキーの設定
     *
     * @var string
     */
    protected $primaryKey = 'VIEW_FLG';

    /**
     * プライマリーキーの型
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * IDの自動増分を無効化
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * タイムスタンプを更新するカラム名
     *
     * @var array
     */
    const CREATED_AT = 'INS_DATE';
    const UPDATED_AT = 'UPD_DATE';

    /**
     * 複数代入可能な属性
     *
     * @var array
     */
    protected $fillable = [
        'VIEW_FLG',
        'COMMENT',
        'SPARE1',
        'SPARE2',
        'DEL_FLG',
    ];

    /**
     * 属性のキャスト
     *
     * @var array
     */
    protected $casts = [
        'VIEW_FLG' => 'string',
        'COMMENT' => 'string',
        'SPARE1' => 'string',
        'SPARE2' => 'string',
        'INS_DATE' => 'datetime',
        'UPD_DATE' => 'datetime',
        'DEL_FLG' => 'string',
    ];

    /**
     * 属性のデフォルト値
     *
     * @var array
     */
    protected $attributes = [
        'DEL_FLG' => '0',
    ];

    /**
     * スコープ：削除されていないレコードのみを取得
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotDeleted($query)
    {
        return $query->where('DEL_FLG', '0');
    }

    /**
     * アクセサ：コメントを取得
     *
     * @return string
     */
    public function getCommentAttribute($value)
    {
        return $value ?? '';
    }

    /**
     * ミューテタ：DEL_FLGを設定
     *
     * @param string $value
     * @return void
     */
    public function setDelFlgAttribute($value)
    {
        $this->attributes['DEL_FLG'] = $value ? '1' : '0';
    }
}