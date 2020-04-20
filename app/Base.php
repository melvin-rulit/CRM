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
    ];

    public function contracts(){
    	return $this->hasMany(Contract::class);
    }
}
