<?php

namespace App\Modules\GestaoProjetos\Contracts\Business;

use App\Modules\GestaoProjetos\DTOs\ProjetoDTO;

interface ExportBoardTrelloBusinessContract extends ExportProjectBusinessContract
{
    public function exportar(int $idProjeto, int $idEquipe): bool;
}
