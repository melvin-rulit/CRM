<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleGroup extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];
}
