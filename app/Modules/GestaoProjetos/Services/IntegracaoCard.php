<?php

namespace App\Modules\GestaoProjetos\Services;

use App\Modules\GestaoProjetos\Config\TrelloConfig;
use App\Modules\GestaoProjetos\DTOs\IntegracaoTarefaDTO;
use App\Modules\GestaoProjetos\DTOs\IntegracaoUsuarioDTO;
use App\Modules\GestaoProjetos\DTOs\ProjetoDTO;
use App\Modules\GestaoProjetos\DTOs\TarefaDTO;
use App\Modules\GestaoProjetos\DTOs\TrelloBoardDTO;
use App\Modules\GestaoProjetos\DTOs\TrelloCardDTO;
use App\Modules\GestaoProjetos\DTOs\TrelloListDTO;
use App\Modules\GestaoProjetos\DTOs\TrelloMemberDTO;
use App\Modules\GestaoProjetos\Libs\Trello\TrelloBoardMembers;
use App\Modules\GestaoProjetos\Libs\Trello\TrelloBoards;
use App\Modules\GestaoProjetos\Libs\Trello\TrelloCards;
use App\System\Contracts\Business\IntegracaoBusinessContract;
use App\System\DTOs\UserDTO;

class IntegracaoCard
{
    public function __construct(
        private readonly TrelloCards $trelloCardService,
        private readonly IntegracaoBusinessContract $integracaoTarefaBusiness
    )
    {
    }
    public function integrar(TarefaDTO $tarefaDTO, TrelloBoardDTO $boardDTO, TrelloListDTO $listTituloAberta):TrelloCardDTO
    {
        $trelloCard = TrelloCardDTO::from([
            'idBoard' => $boardDTO->id,
            'desc'  => $tarefaDTO->descricao,
            'name'  => $tarefaDTO->titulo,
            'start' => $tarefaDTO->inicio_estimado,
            'idList' => $listTituloAberta->id

        ]);

        if($tarefaDTO->integracao?->id_externo != null){
            $trelloCard->id = $tarefaDTO->integracao->id_externo;
            return $this->trelloCardService->update($trelloCard);
        }


       $card = $this->trelloCardService->create($trelloCard);

        $integracaoCard = IntegracaoTarefaDTO::from([
            'tarefa_id' => $tarefaDTO->id,
            'id_externo'    => $card->id,
            'retorno'   => json_encode($card)
        ]);

        $this->integracaoTarefaBusiness->registrarIntegracao($integracaoCard);

        return $card;

    }
}
