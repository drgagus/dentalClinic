<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class PendaftaranMiddleware
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
        if ($user->CEO === 1 or $user->pendaftaran === 1){
            return $next($request);
        }else{
            return abort('401');
        }
    }
}
