<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsResidentOrAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $role = Auth::user()->role;
            if ($role === 'residentiel' || $role === 'admin') {
                return $next($request);
            }
        }

        abort(403, 'Accès refusé.');
    }
}
