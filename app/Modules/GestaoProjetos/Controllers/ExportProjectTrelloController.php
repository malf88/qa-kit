<?php

namespace App\Modules\GestaoProjetos\Controllers;

use App\Modules\GestaoProjetos\Contracts\Business\ExportProjectTrelloBusinessContract;
use App\System\Http\Controllers\Controller;
use App\System\Traits\TransactionDatabase;
use App\System\Utils\EquipeUtils;

class ExportProjectTrelloController extends Controller
{
    use TransactionDatabase;
    public function __construct(
        private readonly ExportProjectTrelloBusinessContract $exportProjectTrelloBusiness
    )
    {
    }
    public function exportar(int $idProjeto)
    {
        return $this->exportProjectTrelloBusiness->exportar($idProjeto, EquipeUtils::equipeUsuarioLogado());
    }

}
