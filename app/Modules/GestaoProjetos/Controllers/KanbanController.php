<?php

namespace App\Modules\GestaoProjetos\Controllers;

use App\Modules\GestaoProjetos\Contracts\Business\ProjetoBusinessContract;
use App\Modules\GestaoProjetos\DTOs\TrelloBoardDTO;
use App\Modules\GestaoProjetos\DTOs\TrelloCardDTO;
use App\Modules\GestaoProjetos\DTOs\TrelloLabelDTO;
use App\Modules\GestaoProjetos\DTOs\TrelloMemberDTO;
use App\Modules\GestaoProjetos\Libs\Trello\TrelloBoardLabels;
use App\Modules\GestaoProjetos\Libs\Trello\TrelloBoardMembers;
use App\Modules\GestaoProjetos\Libs\Trello\TrelloBoards;
use App\Modules\GestaoProjetos\Libs\Trello\TrelloBoardCards;
use App\Modules\GestaoProjetos\Libs\Trello\TrelloCards;
use App\Modules\GestaoProjetos\Libs\Trello\TrelloLists;
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
        $trello = new TrelloBoardLabels(
            key: '4af9dd9f228be32b068c307a01ee268f',
            token: 'ATTAe8d2bec2b9b0a5874bb88ccda0d6d0c5d187feea9d6e15c6a7ef643276d48ba8D8DEF6DB');
        //TrelloBoardDTO::from(['id' => '64dc1acf57bc186d86fc3623', 'name' => 'Projeto 1']))
        dd($trello->create('64dc1acf57bc186d86fc3623',TrelloLabelDTO::from(['name' => 'Marco', 'color' => 'blue'])));
        $projeto = $this->projetoBusiness
                        ->buscarPorIdProjeto($idProjeto, EquipeUtils::equipeUsuarioLogado());
        return view('gestao-projetos::kanban.home');
    }
}
