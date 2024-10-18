<?php

namespace App\Jobs;

use App\Services\SimulacaoCreditoService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessarOfertasJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $cpf;

    /**
     * Create a new job instance.
     *
     * @param string $cpf
     */
    public function __construct($cpf)
    {
        $this->cpf = $cpf;
    }

    /**
     * Execute the job.
     *
     * @param SimulacaoCreditoService $ofertaService
     * @return void
     */
    public function handle(SimulacaoCreditoService $ofertaService)
    {
        $ofertaService->getOfertaCredito($this->cpf);
    }
}
