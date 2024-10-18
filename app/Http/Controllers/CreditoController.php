<?php

namespace App\Http\Controllers;

use App\Services\SimulacaoCreditoService;
use Illuminate\Http\Request;

class CreditoController extends Controller
{
    public $service;

    public function __construct(SimulacaoCreditoService $service)
    {
        $this->service = $service;
    }

    public function consultaOfertaCredito(Request $request)
    {
        $request->validate([
            // 'cpf' => 'required|cpf' // Em uma api real, trabalharia a validação de cpf.
            'ordenacao' => ['nullable', 'in:QntParcelaMin,valorMin,jurosMes']
         ]);

         $cpf = $request->input('cpf');
         $ordenacao = $request->input('ordenacao') ?? null;

         return $this->service->getOfertaCredito($cpf, $ordenacao);
    }

}
