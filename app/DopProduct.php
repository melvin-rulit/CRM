<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DopProduct extends Model
{
    protected $fillable = [
    	'name',
    	'price',
    	'branch_id',
    ];
}
