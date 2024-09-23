<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AlreadyLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if(Session()->has('loginId') && (url('admin/login')==$request->url() || url('admin/register')==$request->url())){
            return redirect('admin/dashboard');  // 改为重定向到仪表板
        }
        return $next($request);
    }
}
