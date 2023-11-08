<?php

namespace App\Modules\GestaoProjetos\Controllers;

use App\Modules\GestaoProjetos\Contracts\Business\ExportBoardTrelloBusinessContract;
use App\Modules\GestaoProjetos\Contracts\Business\ImportBoardTrelloBusinessContract;
use App\System\Http\Controllers\Controller;
use App\System\Traits\TransactionDatabase;
use App\System\Utils\EquipeUtils;

class ImportProjectTrelloController extends Controller
{
    use TransactionDatabase;
    public function __construct(
        private readonly ImportBoardTrelloBusinessContract $importBoardTrelloBusiness
    )
    {
    }
    public function importar(int $idProjeto)
    {
        $this->importBoardTrelloBusiness->importar($idProjeto, EquipeUtils::equipeUsuarioLogado());
        return redirect(route('gestao-projetos.projetos.tarefas.index', $idProjeto))
            ->with([Controller::MESSAGE_KEY_SUCCESS => ['Importação do projeto foi enviado para a fila.']]);
    }

}
