<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KassaOperationType extends Model
{
    protected $fillable = [
        'name',
        'branch_id',
        'group_id',
        'coming',
        'out',
        'cash',
        'beznal',
        'coment',
    ];

    public function group()
    {
        return $this->belongsTo(KassaGroup::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
