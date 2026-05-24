<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login');
        }

        $user = Auth::user();
        
        // Super admin has access to everything
        if ($user->role === 'super_admin') {
            return $next($request);
        }

        // Check if user has one of the required roles
        if (!in_array($user->role, $roles)) {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}
