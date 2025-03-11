<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';
    protected $primaryKey = 'FILE_NAME';
    public $incrementing = false;
    protected $keyType = 'string';
    const CREATED_AT = 'INS_DATE';
    const UPDATED_AT = 'UPD_DATE';
    public $timestamps = true;

    protected $fillable = [
        'FILE_NAME', 'TALENT_ID', 'NEWS_ID', 'FILE_PATH', 'VIEW_FLG', 'PRIORITY',
        'COMMENT', 'SPARE1', 'SPARE2', 'DEL_FLG'
    ];

    protected $dates = ['INS_DATE', 'UPD_DATE'];

    public function talent()
    {
        return $this->belongsTo(Talent::class, 'TALENT_ID', 'TALENT_ID');
    }

    public function scopeActive($query)
    {
        return $query->where('DEL_FLG', '0');
    }

    public function scopeVisible($query)
    {
        return $query->where('VIEW_FLG', '!=', '00');
    }
}
