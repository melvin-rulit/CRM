<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KassaGroup extends Model
{

    protected $fillable =[
        "name",
        "branch_id",
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
