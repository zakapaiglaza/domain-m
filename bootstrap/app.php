<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withKernels()
    ->withSchedule(function (Schedule $schedule) {
        $schedule->command('sanctum:prune-expired --hours=24')
            ->daily()
            ->withoutOverlapping();

        $schedule->command('queue:prune-failed --hours=72')
            ->dailyAt('03:00')
            ->withoutOverlapping();

        $schedule->job(new \App\Jobs\CheckDomainsJob())
            ->everyMinute()
            ->name('check-domains-availability')
            ->withoutOverlapping();

        $schedule->command('domain-monitor:report-failures')
            ->dailyAt('08:00');
    })
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
