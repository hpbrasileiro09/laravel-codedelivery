<?php

namespace CodeDelivery\Http\Middleware;

use Illuminate\Support\Facades\Auth;

use Closure;

class CheckRole
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
        if (!Auth::check()) {
            \Storage::append('codedelivery.log', '00-CheckRole-!check');
            return redirect('/auth/login');
        }
        if (Auth::user()->role <> "admin") {
            \Storage::append('codedelivery.log', '00-CheckRole-role <> admin');
            return redirect('/auth/login');
        }
        return $next($request);
    }
}
