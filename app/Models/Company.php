<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'companies';
    protected $primaryKey = 'COMPANY_NAME';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'COMPANY_NAME', 'ESTABLISHMENT_DATE', 'DIRECTOR', 'POST_CODE',
        'LOCATION', 'CONTENT', 'SNS_1', 'SNS_2', 'SNS_3',
        'SPARE1', 'SPARE2', 'DEL_FLG'
    ];

    protected $dates = ['ESTABLISHMENT_DATE', 'INS_DATE', 'UPD_DATE'];

    public function scopeActive($query)
    {
        return $query->where('DEL_FLG', '0');
    }
}