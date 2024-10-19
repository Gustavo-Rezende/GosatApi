<?php

namespace App\Console;

use App\Jobs\ProcessarOfertasJob;
use Illuminate\Support\Facades\Redis;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $cpfKeys = Redis::keys('oferta:*');

        foreach ($cpfKeys as $key) {
            $cpf = explode(':', $key)[1];

            $schedule->job(new ProcessarOfertasJob($cpf))->everyMinute();
        }
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
