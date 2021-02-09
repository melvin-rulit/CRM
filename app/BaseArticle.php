<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaseArticle extends Model
{
    protected $fillable = [
        'warehouse_article_id',
        'base_id',
        'user_id',
        'quantity',
    ];


    public function warehouse_article(){
        return $this->hasOne('App\WarehouseArticle', 'id', 'warehouse_article_id');
    }

    public function user(){
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
