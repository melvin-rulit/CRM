<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract_pay extends Model
{
    protected $fillable = [
        'contract_id',
        'name',
        'start',
    ];
}
