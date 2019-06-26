<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AdminPrivilege
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
        if(Auth::user()->user_role_id == 1 || Auth::user()->user_role_id == 4){
            return $next($request);
        }

        return redirect('/');
    }
}
