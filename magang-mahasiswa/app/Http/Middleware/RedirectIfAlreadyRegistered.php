<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAlreadyRegistered
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $user->mahasiswa) {
            return redirect()->route('mahasiswa.dashboard');
        }

        return $next($request);
    }
}

