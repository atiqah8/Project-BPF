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
   ->withMiddleware(function (Middleware $middleware): void {
    $middleware->alias([
        'role' => \App\Http\Middleware\CekRole::class,
    ]);

    // kalau belum login: karyawan dilempar ke login karyawan, pelanggan ke login pelanggan
    $middleware->redirectGuestsTo(fn ($request) =>
        $request->is('admin', 'admin/*') ? route('karyawan.login') : route('login')
    );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
