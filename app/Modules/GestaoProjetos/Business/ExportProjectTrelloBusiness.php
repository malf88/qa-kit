<?php

namespace App\Modules\GestaoProjetos\Business;

use App\Modules\GestaoProjetos\Contracts\Business\ExportProjectTrelloBusinessContract;
use App\Modules\GestaoProjetos\Contracts\Business\ProjetoBusinessContract;
use App\Modules\GestaoProjetos\DTOs\TarefaDTO;
use App\Modules\GestaoProjetos\DTOs\TrelloBoardDTO;
use App\Modules\GestaoProjetos\DTOs\TrelloCardDTO;
use App\Modules\GestaoProjetos\DTOs\TrelloListDTO;
use App\Modules\GestaoProjetos\DTOs\TrelloMemberDTO;
use App\Modules\GestaoProjetos\Enums\PermissionEnum;
use App\Modules\GestaoProjetos\Enums\TarefaStatusEnum;
use App\Modules\GestaoProjetos\Libs\Trello\TrelloBoardMembers;
use App\Modules\GestaoProjetos\Libs\Trello\TrelloBoards;
use App\Modules\GestaoProjetos\Libs\Trello\TrelloCards;
use App\Modules\GestaoProjetos\Libs\Trello\TrelloLists;
use App\Modules\GestaoProjetos\Services\IntegracaoBoard;
use App\Modules\GestaoProjetos\Services\IntegracaoCard;
use App\Modules\GestaoProjetos\Services\IntegracaoLists;
use App\Modules\GestaoProjetos\Services\IntegracaoUser;
use App\System\Exceptions\NotFoundException;
use App\System\Impl\BusinessAbstract;
use Illuminate\Support\Collection;

class ExportProjectTrelloBusiness extends BusinessAbstract implements ExportProjectTrelloBusinessContract
{
    public function __construct(
        private readonly ProjetoBusinessContract $projetoBusiness
    )
    {

    }

    public function exportar(int $idProjeto, int $idEquipe): bool
    {
        $this->can(PermissionEnum::EXPORTAR_PROJETO_TRELLO->value);
        $projeto = $this->projetoBusiness->buscarPorIdProjeto($idProjeto, $idEquipe);
        if($projeto == null){
            throw new NotFoundException();
        }
        $serviceBoardIntegracao = new IntegracaoBoard();
        $board = $serviceBoardIntegracao->integrar($projeto);

        $integracaoList = new IntegracaoLists();
        $lists = Collection::empty();
        foreach (array_reverse(TarefaStatusEnum::cases()) as $listsName){
            $lists->add($integracaoList->integrar($listsName, $board));
        }
//        $lists = $trelloListService->get(['id' => $board->id]);
        $listAberta = $lists->where('name','=',TarefaStatusEnum::ABERTA->value)->first();


        $projeto->tarefas->each(function(TarefaDTO $tarefa, $indice) use($board, $listAberta){
            $integracaoUser = new IntegracaoUser();
            $user = $integracaoUser->integrar($tarefa->responsavel, $board);

            $integracaoCard = new IntegracaoCard();
            $card = $integracaoCard->integrar($tarefa, $board, $listAberta);
        });

        return true;

    }
}
