<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('admin')->check() || Auth::guard('admin')->user()->remember_token !== session('admin_remember_token')) {
            // Jika tidak cocok, logout dan redirect ke halaman login
            Auth::guard('admin')->logout();
            session()->forget('admin_remember_token');
            return redirect()->route('loginadmin')->with('error', 'Anda harus login untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}