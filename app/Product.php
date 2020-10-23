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
        'old_id',
        'months',
        'days',
        'programm_id',
    ];

    public function pays(){
        return $this->hasMany(Product_pay::class);
    }

    public function getProgramm(){
        return $this->hasOne('App\Programm', 'id', 'programm_id');
    }
}
