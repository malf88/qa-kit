<?php

namespace App\Modules\GestaoProjetos\Contracts\Business;

use App\Modules\GestaoProjetos\DTOs\ProjetoDTO;

interface ExportCardTrelloBusinessContract extends ExportProjectBusinessContract
{
    public function exportar(int $idTarefa, int $idEquipe): bool;
}
