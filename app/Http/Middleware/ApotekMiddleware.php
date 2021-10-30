<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class ApotekMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        if ($user->CEO === 1 or $user->apotek === 1){
            return $next($request);
        }else{
            return abort('401');
        }
    }
}
