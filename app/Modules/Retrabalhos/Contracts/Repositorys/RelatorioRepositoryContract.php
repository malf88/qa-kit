<?php

namespace App\Modules\Retrabalhos\Contracts\Repositorys;

use App\Modules\Retrabalhos\DTOs\FiltrosDTO;
use App\Modules\Retrabalhos\DTOs\RetrabalhoDesenvolvedorDTO;
use Spatie\LaravelData\DataCollection;

interface RelatorioRepositoryContract
{
    public function relatorioRetrabalhoDesenvolvedor(FiltrosDTO $filtrosDTO, int $idEquipe):DataCollection;
}
