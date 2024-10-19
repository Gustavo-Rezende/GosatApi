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
        $instituicao = limparString($ofertaDTO->instituicao);
        $modalidade = limparString($ofertaDTO->modalidade);
        $key = "oferta:{$ofertaDTO->cpf}:{$instituicao}:{$modalidade}";
        $value = json_encode($ofertaDTO);

        Redis::setex($key, 86400, $value);
    }

    public function obterOfertaDoRedis($ofertaDTO)
    {
        $instituicao = limparString($ofertaDTO->instituicao);
        $modalidade = limparString($ofertaDTO->modalidade);
        $key = "oferta:{$ofertaDTO->cpf}:{$instituicao}:{$modalidade}";
        $oferta = Redis::get($key);

        if ($oferta) {
            return json_decode($oferta, true);
        }

        return null;
    }

}
