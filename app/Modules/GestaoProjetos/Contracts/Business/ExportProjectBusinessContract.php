<?php

namespace App\Modules\GestaoProjetos\Contracts\Business;

interface ExportProjectBusinessContract
{
    public function exportar(int $idProjeto, int $idEquipe): bool;
}
