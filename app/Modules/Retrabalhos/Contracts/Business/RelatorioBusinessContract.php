<?php

namespace App\Modules\Retrabalhos\Contracts\Business;

use App\Modules\Retrabalhos\DTOs\FiltrosDTO;
use App\Modules\Retrabalhos\DTOs\RetrabalhoDesenvolvedorDTO;
use Spatie\LaravelData\DataCollection;

interface RelatorioBusinessContract
{
    public function relatorioRetrabalhoDesenvolvedor(FiltrosDTO $filtrosDTO, int $idEquipe):DataCollection;
}
