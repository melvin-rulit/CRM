<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = [
        'name',
        'adress',
        'phone',
        'geolocation',
        'region_id',
    ];

    public function products(){
        return $this->hasMany(Product::class);
    }
}
