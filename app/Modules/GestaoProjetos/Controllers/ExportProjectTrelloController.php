<?php

namespace App\Modules\GestaoProjetos\Controllers;

use App\Modules\GestaoProjetos\Contracts\Business\ExportBoardTrelloBusinessContract;
use App\System\Http\Controllers\Controller;
use App\System\Traits\TransactionDatabase;
use App\System\Utils\EquipeUtils;

class ExportProjectTrelloController extends Controller
{
    use TransactionDatabase;
    public function __construct(
        private readonly ExportBoardTrelloBusinessContract $exportProjectTrelloBusiness
    )
    {
    }
    public function exportar(int $idProjeto)
    {
        $this->exportProjectTrelloBusiness->enfileirarExportacao($idProjeto, EquipeUtils::equipeUsuarioLogado());
        return redirect(route('gestao-projetos.projetos.tarefas.index', $idProjeto))
            ->with([Controller::MESSAGE_KEY_SUCCESS => ['Integração do projeto foi enviado para a fila.']]);
    }

}
