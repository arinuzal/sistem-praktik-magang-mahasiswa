<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotOwnRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        return match ($user->role) {
            'mahasiswa' => redirect()->route('mahasiswa.dashboard'),
            'tempat magang' => redirect()->route('tempatMagang.mahasiswa'),
            'admin', 'super admin' => redirect()->route('filament.dashboard.pages.dashboard'),
            default => redirect()->route('home'),
        };
    }
}
