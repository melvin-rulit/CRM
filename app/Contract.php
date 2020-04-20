<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $fillable = [
        'base_id',
        'name',
        'start',
        'end',
        'end_actually',
        'active',
        'date',
    ];
}