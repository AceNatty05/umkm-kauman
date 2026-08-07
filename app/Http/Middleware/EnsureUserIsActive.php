<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && !$request->user()->is_active) {
            // Check if they are already on dashboard to prevent redirect loop
            if ($request->routeIs('dashboard')) {
                return $next($request);
            }
            return redirect()->route('dashboard')->with('error', 'Akun Anda sedang menunggu persetujuan admin. Anda belum dapat mengelola UMKM.');
        }

        return $next($request);
    }
}
