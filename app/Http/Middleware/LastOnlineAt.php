<?php

namespace App\Http\Middleware;
use DB;
use Closure;
use Auth;
use Carbon\Carbon;

class LastOnlineAt
{
    public function handle($request, Closure $next)
    {
        if (auth()->guest()) {
            return $next($request);
        }

            DB::table("users")
                ->where("id", auth()->user()->id)
                ->update(["last_online_at" => now()]);

        return $next($request);
    }
}
