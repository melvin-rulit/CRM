<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KassaOperation extends Model
{
    protected $fillable =[
        "name",
        "branch_id",
        "user_id",
        "operation_type_id",
        "payment",
        "in_or_out",
        "sum",
        "coment"
    ];

    public function kassaOperation()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function kassaOperationType()
    {
        return $this->belongsTo('App\KassaOperationType', 'operation_type_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

}
