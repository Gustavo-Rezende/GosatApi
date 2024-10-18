<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CreditoController;

Route::get('/', function () {
    return view('welcome');
});
