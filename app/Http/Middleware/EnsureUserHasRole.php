<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     * Usage: Route::middleware('role:admin')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        foreach ($roles as $role) {
            if ($request->user()->role === $role) {
                return $next($request);
            }
        }

        // Special handling for dashboard redirect (if a user is redirected here by auth middleware but isn't admin)
        if ($request->routeIs('dashboard')) {
            return redirect()->route('umkm.index');
        }

        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }
}
