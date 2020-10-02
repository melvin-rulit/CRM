<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loger extends Model
{
    protected $fillable = [
        'channel',
        'user_id',
        'level_name',
        'message',
        'base_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
