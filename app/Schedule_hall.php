<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule_hall extends Model
{

	// protected $with = ['programm'];

    public function group(){
        return $this->hasOne('App\Group', 'id', 'group_id');
    }
}
