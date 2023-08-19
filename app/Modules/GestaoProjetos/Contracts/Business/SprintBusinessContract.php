<?php

namespace App\Modules\GestaoProjetos\Contracts\Business;

use App\Modules\GestaoProjetos\DTOs\TarefaDTO;
use Spatie\LaravelData\DataCollection;

interface SprintBusinessContract
{
    public function listarSprints(int $idProjeto, int $idEquipe): DataCollection;
}
