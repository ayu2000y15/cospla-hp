<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Acmail extends Model
{
    protected $table = 'acmails';
    protected $primaryKey = 'AC_ID';
    public $timestamps = true;
    const CREATED_AT = 'INS_DATE';
    const UPDATED_AT = 'UPD_DATE';

    protected $fillable = [
        'AC_ID', 'MAIL', 'COL1', 'COL2', 'COL3',
        'COL4', 'COL5', 'COL6', 'COL7', 'COL8', 'COL9', 'COL10',
        'DELIVERY_FLG', 'INS_DATE', 'UPD_DATE'
    ];
}
