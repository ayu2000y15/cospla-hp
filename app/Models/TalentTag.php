<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TalentTag extends Model
{
    protected $table = 'talent_tags';
    public $timestamps = false;

    protected $fillable = [
        'TALENT_ID', 'TAG_ID', 'SPARE1', 'SPARE2'
    ];

    public function talent()
    {
        return $this->belongsTo(Talent::class, 'TALENT_ID', 'TALENT_ID');
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class, 'TAG_ID', 'TAG_ID');
    }
}