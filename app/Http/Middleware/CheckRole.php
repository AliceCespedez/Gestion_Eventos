<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
{
    if (!Auth::check()) {
        return redirect('/login');
    }

    $user = Auth::user();

    // 🔥 FIX IMPORTANTE
    $roles = collect($roles)
        ->flatMap(fn($r) => explode(',', $r))
        ->map(fn($r) => trim($r))
        ->toArray();

    if (!in_array($user->rol, $roles)) {
        return redirect('/')
            ->with('error', 'No tienes permisos para acceder a esta sección');
    }

    return $next($request);
}
}