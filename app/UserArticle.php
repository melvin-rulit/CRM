<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserArticle extends Model
{
    protected $fillable = [
        'warehouse_article_id',
        'user_id',
        'who_user_id',
        'quantity',
    ];

    public function warehouse_article(){
        return $this->hasOne('App\WarehouseArticle', 'id', 'warehouse_article_id');
    }

    public function user(){
        return $this->hasOne('App\User', 'id', 'who_user_id');
    }
}
