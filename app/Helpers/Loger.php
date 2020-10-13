<?php

use App\Loger;
use Illuminate\Support\Facades\Auth;


function loger($chanel, $base_id = null, $message = null)
{
    Loger::create(array(
            'user_id' => Auth::id(),
            'channel' => $chanel,
            'base_id' => $base_id,
            'level_name' => 'success',
            'message' => $message)
    );
}
