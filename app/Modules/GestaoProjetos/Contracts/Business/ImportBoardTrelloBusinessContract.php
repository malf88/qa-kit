<?php

namespace App\Modules\GestaoProjetos\Contracts\Business;

use App\Modules\GestaoProjetos\DTOs\ProjetoDTO;

interface ImportBoardTrelloBusinessContract
{
    public function importar(int $idProjeto, int $idEquipe): bool;
}
