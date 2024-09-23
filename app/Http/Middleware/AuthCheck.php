<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Admin;

class AuthCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if(!Session()->has('loginId')){
            return redirect('admin/login')->with('fail', 'You need to login first');
        }

        // 添加数据库检查
        $admin = Admin::find(Session()->get('loginId'));
        if(!$admin){
            Session()->forget('loginId');
            return redirect('admin/login')->with('fail', 'Admin not found. Please login again.');
        }

        return $next($request);
    }
}
