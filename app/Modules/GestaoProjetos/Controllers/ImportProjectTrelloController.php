<?php

namespace App\Modules\GestaoProjetos\Controllers;

use App\Modules\GestaoProjetos\Contracts\Business\ExportBoardTrelloBusinessContract;
use App\System\Http\Controllers\Controller;
use App\System\Traits\TransactionDatabase;
use App\System\Utils\EquipeUtils;

class ImportProjectTrelloController extends Controller
{
    use TransactionDatabase;
    public function __construct(

    )
    {
    }
    public function importar(int $idProjeto)
    {
        return redirect(route('gestao-projetos.projetos.tarefas.index', $idProjeto))
            ->with([Controller::MESSAGE_KEY_SUCCESS => ['Importação do projeto foi enviado para a fila.']]);
    }

}
