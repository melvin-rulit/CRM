<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{

	protected $fillable = [
        'name',
        'hall_id',
        'programm_id',
        'color',
    ];


    public function children()
    {
        return $this->hasMany(Base::class);
    }

    public function schedule_hall()
    {
        return $this->hasMany(Schedule_hall::class);
    }

    public function programm(){
        return $this->hasOne('App\Programm', 'id', 'programm_id');
    }
}
