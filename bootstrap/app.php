<?php
   
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Barryvdh\DomPDF\Facade\Pdf;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'Admin' => \App\Http\Middleware\AdminMiddleware::class,
            'Student' => \App\Http\Middleware\StudentMiddleware::class,
             'PDF' => Barryvdh\DomPDF\Facade\Pdf::class,
        ]);
        
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();        
