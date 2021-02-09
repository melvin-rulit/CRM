<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $fillable = [
        'name',
        'branch_id',
        'user_id',
        'description',
    ];

    public function articles() {
        return $this->hasMany(WarehouseArticle::class);
    }
}
