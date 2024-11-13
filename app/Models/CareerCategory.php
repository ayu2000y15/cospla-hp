<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CareerCategory extends Model
{
    protected $table = 'career_categories';
    protected $primaryKey = 'CAREER_CATEGORY_ID';
    const CREATED_AT = 'INS_DATE';
    const UPDATED_AT = 'UPD_DATE';
    public $timestamps = true;

    protected $fillable = [
        'CAREER_CATEGORY_NAME', 'SPARE1', 'SPARE2', 'DEL_FLG'
    ];

    protected $dates = ['INS_DATE', 'UPD_DATE'];

    public function careers()
    {
        return $this->hasMany(TalentCareer::class, 'CAREER_CATEGORY_ID', 'CAREER_CATEGORY_ID');
    }

    public function scopeActive($query)
    {
        return $query->where('DEL_FLG', '0');
    }
}