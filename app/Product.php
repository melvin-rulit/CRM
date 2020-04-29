<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

	protected $fillable = [
    	'name',
    	'price',
    	'price_title',
    	'classes_total',
    	'classes_week',
    	'category_time',
    	'freezing_total',
    	'active',
        'branch_id',
    ];
}
