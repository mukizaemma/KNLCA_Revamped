<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureSessionIsValid
{
    /**
     * Log out users whose session_version was bumped (force logout).
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            if (! $request->session()->has('user_session_version')) {
                $request->session()->put('user_session_version', (int) $user->session_version);
            } elseif ((int) $request->session()->get('user_session_version') !== (int) $user->session_version) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                if ($request->is('admin') || $request->is('admin/*')) {
                    return redirect()->route('admin.login')
                        ->with('status', 'Your session was ended by an administrator. Please sign in again.');
                }

                return redirect()->route('login')
                    ->with('status', 'Your session was ended by an administrator. Please sign in again.');
            }
        }

        return $next($request);
    }
}
