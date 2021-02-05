<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'name',
        'article_group_id',
        'supplier_id',
        'description',
    ];


    public function article_group(){
        return $this->hasOne('App\ArticleGroup', 'id', 'article_group_id');
    }

    public function supplier(){
        return $this->hasOne('App\Supplier', 'id', 'supplier_id');
    }
}
