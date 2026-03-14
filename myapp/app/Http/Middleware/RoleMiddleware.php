<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        $user = $request->user();

        if (! $user->role) {
            abort(403, 'Your account has no role assigned.');
        }

        if (! in_array($user->role->slug, $roles)) {
            abort(403, 'You do not have permission to access this area.');
        }

        // For instructors, check if approved (unless admin)
        if ($user->role->slug === 'instructor' && ! $user->is_approved && ! $user->isAdmin()) {
            return redirect()->route('dashboard')
                ->with('warning', 'Your instructor account is pending approval.');
        }

        return $next($request);
    }
}
