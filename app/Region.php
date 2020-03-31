<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $fillable = [
    	'name'
    ];

    public function branches(){
    	return $this->hasMany(Branch::class);
    }

    static function getIsRegionAttribute($id)
    {
        return Region::find($id);
    }
}
