<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Oferta extends Model
{
    use HasFactory;

    protected $fillable = [
        'cpf',
        'instituicao',
        'modalidade',
        'QntParcelaMin',
        'QntParcelaMax',
        'valorMin',
        'valorMax',
        'jurosMes',
    ];
}
