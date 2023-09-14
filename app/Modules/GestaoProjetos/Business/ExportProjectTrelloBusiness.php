<?php

namespace App\Modules\GestaoProjetos\Business;

use App\Modules\GestaoProjetos\Contracts\Business\ExportProjectTrelloBusinessContract;
use App\Modules\GestaoProjetos\Contracts\Business\ProjetoBusinessContract;
use App\Modules\GestaoProjetos\DTOs\TarefaDTO;
use App\Modules\GestaoProjetos\DTOs\TrelloBoardDTO;
use App\Modules\GestaoProjetos\DTOs\TrelloCardDTO;
use App\Modules\GestaoProjetos\DTOs\TrelloListDTO;
use App\Modules\GestaoProjetos\Enums\PermissionEnum;
use App\Modules\GestaoProjetos\Enums\TarefaStatusEnum;
use App\Modules\GestaoProjetos\Libs\Trello\TrelloBoards;
use App\Modules\GestaoProjetos\Libs\Trello\TrelloCards;
use App\Modules\GestaoProjetos\Libs\Trello\TrelloLists;
use App\System\Exceptions\NotFoundException;
use App\System\Impl\BusinessAbstract;

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
        $board = TrelloBoardDTO::from([
            'name' => $projeto->nome,
            'desc' => $projeto->descricao,
            'labelNames' => ['PHP', 'JAVA'],
            'defaultLists' => false
        ]);

        $trelloBoardService = new TrelloBoards(
            'ATTAe8d2bec2b9b0a5874bb88ccda0d6d0c5d187feea9d6e15c6a7ef643276d48ba8D8DEF6DB',
            '4af9dd9f228be32b068c307a01ee268f'
        );
        $board = $trelloBoardService->create($board);
        $trelloListService = new TrelloLists(
            'ATTAe8d2bec2b9b0a5874bb88ccda0d6d0c5d187feea9d6e15c6a7ef643276d48ba8D8DEF6DB',
            '4af9dd9f228be32b068c307a01ee268f'
        );
        foreach (TarefaStatusEnum::cases() as $lists){
            $trelloList = TrelloListDTO::from([
                'name' => $lists->value,
                'idBoard'   => $board->id
            ]);

            $trelloListService->create($board->id, $trelloList);
        }
        $lists = $trelloListService->get(['id' => $board->id]);
        $idListAberta = $lists->where('name','=',TarefaStatusEnum::ABERTA->value)->first()->id;
        $trelloCardService = new TrelloCards(
            'ATTAe8d2bec2b9b0a5874bb88ccda0d6d0c5d187feea9d6e15c6a7ef643276d48ba8D8DEF6DB',
            '4af9dd9f228be32b068c307a01ee268f'
        );

        $projeto->tarefas->each(function(TarefaDTO $tarefa, $indice) use($board, $trelloCardService, $idListAberta){
            $trelloCard = TrelloCardDTO::from([
                'idBoard' => $board->id,
                'desc'  => $tarefa->descricao,
                'name'  => $tarefa->titulo,
                'start' => $tarefa->inicio_estimado,
                'idList' => $idListAberta

            ]);

            $trelloCardService->create($trelloCard);
        });

        return true;

    }
}
