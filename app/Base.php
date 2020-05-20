<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Base extends Model
{
    //use SoftDeletes;

    protected $fillable = [
        'child_name',
        'child_surname',
        'child_middle_name',
        'branch',
        'manager',
        'instructor',
        'programm_id',
        'avatar',
    ];

    public function contracts(){
    	return $this->hasMany(Contract::class);
    }

    public function base_branch(){
    	return $this->hasOne('App\Branch', 'id', 'branch');
    }

    public function base_manager(){
        return $this->hasOne('App\User', 'id', 'manager');
    }

    public function base_instructor(){
        return $this->hasOne('App\User', 'id', 'instructor');
    }

    public function programm(){
        return $this->hasOne('App\Programm', 'id', 'programm_id');
    }

    public function scopeFilter($builder, $filters)
    {
        return $filters->apply($builder);
    }
}
