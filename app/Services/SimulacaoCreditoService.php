<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;


class SimulacaoCreditoService
{
    public function getCredito($cpf)
    {
        return Http::gosatapi()->post('/credito', [
            'cpf' => $cpf
        ]);
    }

    public function getOferta($cpf, $instituicao, $modalidade)
    {
        return Http::gosatapi()->post('/oferta', [
            'cpf' => $cpf,
            'instituicao_id' => $instituicao,
            'codModalidade' => $modalidade
        ]);
    }

    public function getInstituicaoFinanceira($cpf)
    {
         $dadosInstituicoes = $this->getCredito($cpf);

         if ($dadosInstituicoes->failed()) {
             return response()->json(['error' => 'Erro ao buscar instituições'], 500);
         }

         return $dadosInstituicoes->json()['instituicoes'];
    }

    public function getOfertaCredito($cpf, $ordenacao)
    {
         $instituicoes = $this->getInstituicaoFinanceira($cpf);

         $ofertas = [];

         foreach ($instituicoes as $instituicao) {
             foreach ($instituicao['modalidades'] as $modalidade) {
                 $responseOferta = $this->getOferta($cpf, $instituicao['id'], $modalidade['cod']);

                 if ($responseOferta->successful()) {
                     $ofertas[] = [
                         'instituicao' => $instituicao['nome'],
                         'modalidade' => $modalidade['nome'],
                         'oferta' => $responseOferta->json()
                     ];
                 }
             }
         }

         // Aplicar ordenação, se fornecida
        if ($ordenacao) {
            usort($ofertas, function ($a, $b) use ($ordenacao) {
                return $a['oferta'][$ordenacao] <=> $b['oferta'][$ordenacao];
            });
        }

         return response()->json($ofertas);
    }
}
