<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $fillable = [
        'base_id',
        'day',
        'month',
        'year',
        'icon',
        'type',
    ];
}
