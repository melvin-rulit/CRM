<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hall extends Model
{
    protected $fillable = [
    	'name',
    	'branch_id',
    ];

    public function schedule_hall() {
        return $this->hasMany(Schedule_hall::class);
    }

    public function branch(){
        return $this->hasOne('App\Branch', 'id', 'branch_id');
    }
}
