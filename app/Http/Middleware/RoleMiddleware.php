<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Jika tidak log masuk, atau peranan tidak sepadan
        $userRole = Auth::user()?->role;
        $allowedRoles = match ($role) {
            'jkdm' => ['jkdm', 'ketua_unit_jkdm'],
            'ketua' => ['ketua_unit_jkdm'],
            default => [$role],
        };

        if (! Auth::check() || ! in_array($userRole, $allowedRoles, true)) {
            abort(403, 'Akses Terhalang! Peranan Tidak Dibenarkan.');
        }

        return $next($request);
    }
}
