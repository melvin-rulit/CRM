<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    protected $fillable = [
        'base_id',
        'user_id',
        'comment',
    ];


    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
