<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_pay extends Model
{
    protected $fillable = [
    	'product_id',
        'pay',
        'day',
    ];
}
