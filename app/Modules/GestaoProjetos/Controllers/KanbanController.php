<?php

namespace App\Modules\GestaoProjetos\Controllers;

use App\Modules\GestaoProjetos\Contracts\Business\ProjetoBusinessContract;
use App\Modules\GestaoProjetos\Libs\Trello\TrelloMeusBoards;
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
        $trello = new TrelloMeusBoards(
            key: '4af9dd9f228be32b068c307a01ee268f',
            token: 'ATTAe8d2bec2b9b0a5874bb88ccda0d6d0c5d187feea9d6e15c6a7ef643276d48ba8D8DEF6DB');
        dd($trello->send([]));
        $projeto = $this->projetoBusiness
                        ->buscarPorIdProjeto($idProjeto, EquipeUtils::equipeUsuarioLogado());
        return view('gestao-projetos::kanban.home');
    }
}
