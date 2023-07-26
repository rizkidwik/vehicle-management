<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Symfony\Component\HttpFoundation\Response;

class CheckLevel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,$level): Response
    {
        if ($request->user()->level == $level) {
            return $next($request);
        }

        if($request->user()->level == 'admin'){
            return redirect()->intended(RouteServiceProvider::HOME_ADMIN);
        } else {
            return redirect()->intended(RouteServiceProvider::HOME_APPROVE);
        }
    }
}
