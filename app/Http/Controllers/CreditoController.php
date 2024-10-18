<?php

namespace App\Http\Controllers;

use App\Services\SimulacaoCreditoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CreditoController extends Controller
{
    public $service;

    public function __construct()
    {
        $this->service = new SimulacaoCreditoService();
    }

    public function consultaInstituicaoFinanceira(Request $request)
    {
        $request->validate([
            // 'cpf' => 'required|cpf'
         ]);

         $cpf = $request->input('cpf');

         return $this->service->getInstituicaoFinanceira($cpf);
    }

    public function consultaOfertaCredito(Request $request)
    {
        $request->validate([
            // 'cpf' => 'required|cpf'
            'ordenacao' => ['nullable', 'in:QntParcelaMin,valorMin,jurosMes']
         ]);

         $cpf = $request->input('cpf');
         $ordenacao = $request->input('ordenacao') ?? null;

         return $this->service->getOfertaCredito($cpf, $ordenacao);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
