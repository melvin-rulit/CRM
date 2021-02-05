<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $fillable = [
        'name',
        'branch_id',
        'user_id',
        'supplier',
        'description',
    ];

    public function positions() {
        return $this->hasMany(WarehousePosition::class);
    }
}
