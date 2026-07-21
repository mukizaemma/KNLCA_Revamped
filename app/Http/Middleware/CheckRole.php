<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! Auth::check()) {
            return redirect()->route('admin.login');
        }

        $user = Auth::user();

        // Only the designated super admin email bypasses role checks.
        if ($user->isSuperAdmin()) {
            return $next($request);
        }

        // Treat mis-tagged "super_admin" accounts as website_admin for access.
        $effectiveRole = $user->role === 'super_admin' ? 'website_admin' : $user->role;

        if (! in_array($effectiveRole, $roles, true)) {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}
