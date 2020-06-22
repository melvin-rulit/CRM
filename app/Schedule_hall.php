<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule_hall extends Model
{

	// protected $with = ['programm'];

    public function programm(){
        return $this->hasOne('App\Programm', 'id', 'programm_id');
    }
}
