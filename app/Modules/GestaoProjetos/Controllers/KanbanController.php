<?php

namespace App\Modules\GestaoProjetos\Controllers;

use App\Modules\GestaoProjetos\Contracts\Business\ProjetoBusinessContract;
use App\System\Http\Controllers\Controller;
use App\System\Utils\EquipeUtils;

class KanbanController extends Controller
{
    public function __construct(
        private readonly ProjetoBusinessContract $projetoBusiness
    )
    {
    }
    public function index(int $idProjeto){
        $projeto = $this->projetoBusiness
                        ->buscarPorIdProjeto($idProjeto, EquipeUtils::equipeUsuarioLogado());
        return view('gestao-projetos::kanban.home');
    }
}
