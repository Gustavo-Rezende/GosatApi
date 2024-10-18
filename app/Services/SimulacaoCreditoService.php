<?php
namespace App\Services;

use App\DTOs\OfertaDTO;
use Illuminate\Support\Facades\Http;
use App\Repositories\OfertaRepository;

class SimulacaoCreditoService
{
    protected $ofertaRepository;

    public function __construct(OfertaRepository $ofertaRepository)
    {
        $this->ofertaRepository = $ofertaRepository;
    }

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

    public function getOfertaCredito($cpf, $ordenacao = null)
    {
         $instituicoes = $this->getInstituicaoFinanceira($cpf);

         $ofertas = [];

         foreach ($instituicoes as $instituicao) {
             foreach ($instituicao['modalidades'] as $modalidade) {
                 $responseOferta = $this->getOferta($cpf, $instituicao['id'], $modalidade['cod']);

                 if ($responseOferta->successful()) {
                    $ofertaData = $responseOferta->json();

                     $ofertaDTO = new OfertaDTO($cpf, $instituicao['nome'], $modalidade['nome'], $ofertaData);

                     $this->ofertaRepository->salvarOferta($ofertaDTO);
                     $this->ofertaRepository->salvarOfertaNoRedis($ofertaDTO);
                     $ofertas[] = $ofertaDTO;
                 }
             }
         }


         if ($ordenacao) {
             usort($ofertas, function ($a, $b) use ($ordenacao) {
                 return $a->{$ordenacao} <=> $b->{$ordenacao};
             });
         }

         return response()->json($ofertas);
    }
}
