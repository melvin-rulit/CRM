<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule_hall extends Model
{

	protected $fillable = [
        'hall_id',
        'group_id',
        'day',
        'time',
        'minute',
        'category_time',
    ];

    public function group(){
        return $this->hasOne('App\Group', 'id', 'group_id');
    }

}
