<?php

namespace App\DTOs;

class OfertaDTO
{
    public $cpf;
    public $instituicao;
    public $modalidade;
    public $QntParcelaMin;
    public $QntParcelaMax;
    public $valorMin;
    public $valorMax;
    public $jurosMes;

    public function __construct($cpf, $instituicao, $modalidade, $ofertaData)
    {
        $this->cpf = $cpf;
        $this->instituicao = $instituicao;
        $this->modalidade = $modalidade;
        $this->QntParcelaMin = $ofertaData['QntParcelaMin'];
        $this->QntParcelaMax = $ofertaData['QntParcelaMax'];
        $this->valorMin = $ofertaData['valorMin'];
        $this->valorMax = $ofertaData['valorMax'];
        $this->jurosMes = $ofertaData['jurosMes'];
    }
}
