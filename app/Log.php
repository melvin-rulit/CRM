<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = [
        'channel',
        'user_id',
        'level_name',
        'message',
    ];
}
