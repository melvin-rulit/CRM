<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $fillable = [
        'base_id',
        'name',
        'start',
        'end',
        'end_actually',
        'active',
        'date',
        'child_surname',
        'child_name', 
        'child_middle_name', 
        'child_birthday', 
        'parent_surname', 
        'parent_name',
        'parent_middle_name', 
        'parent_phone', 
        'parent_viber', 
        'parent_email', 
        'parent_facebook', 
        'parent_instagram', 
        'programm',
        'contract_type',
    ];

    public function contract_pays(){
        return $this->hasMany(Contract_pay::class);
    }
}