<?php

namespace App\Http\Middleware;

use Closure;

class CheckPpraUser
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
        if(session('pprauser') == 1)
        return $next($request); 
        return redirect('/home');
        
    }
}
