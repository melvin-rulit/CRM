<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class PromoterMiddleware
{



    public function handle($request, Closure $next)
    {
        if(Auth::user()->hasRole('Промоутер')) {

            return redirect()->route('promouter');
        }

        return $next($request);
    }
}
