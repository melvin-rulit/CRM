<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleAccess extends Model
{
        protected $fillable = [
        'role_id',
        'role_access',
        'name',
    ];

    public $timestamps = false;

}
