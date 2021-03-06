<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    protected $fillable = [
        'name',
        'group_id',
        'coment',
    ];

    public function group()
    {
        return $this->belongsTo(SourceGroup::class);
    }
}
