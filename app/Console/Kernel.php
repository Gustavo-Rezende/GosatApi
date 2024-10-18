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
            // Extrair o CPF da chave. Supondo que a chave seja do formato 'oferta:{cpf}:instituicao:modalidade'
            $cpf = explode(':', $key)[1];

            // Para cada CPF, agendar o job dinamicamente
            $schedule->job(new ProcessarOfertasJob($cpf))->everyFiveMinutes();
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
