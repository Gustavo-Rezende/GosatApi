<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CreditoController;

Route::middleware('api')->group(function () {
    Route::post('/consulta-credito', [CreditoController::class, 'consultaInstituicaoFinanceira']);
    Route::post('/oferta-credito', [CreditoController::class, 'consultaOfertaCredito']);
});



