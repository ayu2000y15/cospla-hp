<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactCategory extends Model
{
    protected $table = 'contact_categories';
    protected $primaryKey = 'CONTACT_CATEGORY_ID';
    const CREATED_AT = 'INS_DATE';
    const UPDATED_AT = 'UPD_DATE';
    public $timestamps = true;

    protected $fillable = [
        'CONTACT_CATEGORY_NAME', 'REFERENCE_CODE', 'SPARE1', 'SPARE2', 'DEL_FLG'
    ];

    protected $dates = ['INS_DATE', 'UPD_DATE'];

    public function contacts()
    {
        return $this->hasMany(Contact::class, 'CONTACT_CATEGORY_ID', 'CONTACT_CATEGORY_ID');
    }

    public function scopeActive($query)
    {
        return $query->where('DEL_FLG', '0');
    }
}
