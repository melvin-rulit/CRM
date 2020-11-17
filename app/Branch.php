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

    public function bases(){
        return $this->hasMany('App\Base', 'branch');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'user_branches');
    }

    public function programms(){
        return $this->hasMany(Programm::class);
    }

    public function dopproducts(){
        return $this->hasMany(DopProduct::class);
    }

    public function halls() {
        return $this->hasMany(Hall::class);
    }

    public function kassa_operation_type() {
        return $this->hasMany(KassaOperationType::class);
    }

    public function kassa_group() {
        return $this->hasMany(KassaGroup::class);
    }

    public function kassa_operation() {
        return $this->hasMany(KassaOperation::class);
    }

    // Получаем все кассы у филиала ????????????????????????????
    public function kassa() {
        return $this->hasMany(Kassa::class);
    }
}
