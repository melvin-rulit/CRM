<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WarehouseArticle extends Model
{
    protected $fillable = [
        'article_id',
        'warehouse_id',
        'quantity',
    ];

    public function article(){
        return $this->hasOne('App\Article', 'id', 'article_id');
    }

    public function warehouse(){
        return $this->hasOne('App\Warehouse', 'id', 'warehouse_id');
    }

    public function group(){
        return $this->hasOne('App\ArticleGroup', 'id', 'article_group_id');
    }
}
