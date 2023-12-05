<?php

namespace App\Http\Middleware;

use App\Models\Visitor;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class VisitorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $sessionId = Session::getId();
        $ipAddress = $request->ip();
        
        $existingVisitor = Visitor::where('ip_address', $ipAddress)->first();
    
        if (!$existingVisitor) {
            Visitor::create([
                'session_id' => $sessionId,
                'ip_address' => $ipAddress
            ]);
        }
    
        return $next($request);
        }
}