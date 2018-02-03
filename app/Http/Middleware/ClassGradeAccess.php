<?php

namespace App\Http\Middleware;

use Closure;

class ClassGradeAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$adviser)
    {
        
        $user = \Auth::user()->idno;
        if($adviser == $user){
            return $next($request);
        }else{
            return false;
        }
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return back()->guest('login');
            }
        }

        
    }
}
