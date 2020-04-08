<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Base extends Model
{
    //use SoftDeletes;

    protected $fillable = [
        'child_name',
        'mother_phone',
        'source',
        'notes',
    ];
}
