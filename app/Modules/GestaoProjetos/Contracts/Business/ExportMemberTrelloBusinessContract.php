<?php

namespace App\Modules\GestaoProjetos\Contracts\Business;

use App\Modules\GestaoProjetos\DTOs\ProjetoDTO;

interface ExportMemberTrelloBusinessContract extends ExportProjectBusinessContract
{
    public function exportar(int $idUsuario, int $idEquipe): bool;
}
