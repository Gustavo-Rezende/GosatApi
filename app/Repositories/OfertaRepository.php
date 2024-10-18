<?php

namespace App\Repositories;

use App\Models\Oferta;
use Illuminate\Support\Facades\Redis;

class OfertaRepository
{
    public function salvarOferta($ofertaDTO)
    {
        Oferta::updateOrCreate(
            [
                'cpf' => $ofertaDTO->cpf,
                'instituicao' => $ofertaDTO->instituicao,
                'modalidade' => $ofertaDTO->modalidade
            ],
            [
                'QntParcelaMin' => $ofertaDTO->QntParcelaMin,
                'QntParcelaMax' => $ofertaDTO->QntParcelaMax,
                'valorMin' => $ofertaDTO->valorMin,
                'valorMax' => $ofertaDTO->valorMax,
                'jurosMes' => $ofertaDTO->jurosMes
            ]
        );
    }

    public function salvarOfertaNoRedis($ofertaDTO)
    {
        $key = "oferta:{$ofertaDTO->cpf}:{$ofertaDTO->instituicao}:{$ofertaDTO->modalidade}";
        $value = json_encode($ofertaDTO);

        Redis::setex($key, 86400, $value);
    }

    public function obterOfertaDoRedis($ofertaDTO)
    {
        $key = "oferta:{$ofertaDTO->cpf}:{$ofertaDTO->instituicao}:{$ofertaDTO->modalidade}";
        $oferta = Redis::get($key);

        if ($oferta) {
            return json_decode($oferta, true);
        }

        return null;
    }

}
