<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'check.pendaftaran.mahasiswa' => \App\Http\Middleware\RedirectIfMahasiswaNotRegistered::class,
            'role.strict' => \App\Http\Middleware\RedirectIfNotOwnRole::class,
            'mahasiswa.already.registered' => \App\Http\Middleware\RedirectIfAlreadyRegistered::class,
            'prevent.back.history' => \App\Http\Middleware\PreventBackHistory::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
