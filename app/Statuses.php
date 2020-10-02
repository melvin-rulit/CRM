<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Statuses extends Model
{
    public function steps(){
        return $this->hasOne('App\Step', 'id', 'steps_id');
    }

    public function status(){
        return $this->hasOne('App\StatusName', 'id', 'status_id');
    }
}
