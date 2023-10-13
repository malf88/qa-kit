<?php

namespace App\Modules\GestaoProjetos\Services;

use App\Modules\GestaoProjetos\Contracts\Business\TarefaBusinessContract;
use App\Modules\GestaoProjetos\DTOs\IntegracaoTarefaDTO;
use App\Modules\GestaoProjetos\DTOs\TarefaDTO;
use App\Modules\GestaoProjetos\DTOs\TrelloBoardDTO;
use App\Modules\GestaoProjetos\DTOs\TrelloCardDTO;
use App\Modules\GestaoProjetos\DTOs\TrelloListDTO;
use App\Modules\GestaoProjetos\Libs\Trello\TrelloCards;
use App\System\Contracts\Business\IntegracaoBusinessContract;
use Illuminate\Support\Facades\Log;

class IntegracaoCard
{
    public function __construct(
        private readonly TrelloCards $trelloCardService,
        private readonly IntegracaoBusinessContract $integracaoTarefaBusiness,
        private readonly TarefaBusinessContract $tarefaBusiness
    )
    {
    }
    public function integrar(TarefaDTO $tarefaDTO, TrelloBoardDTO $boardDTO, TrelloListDTO $listTituloAberta):TrelloCardDTO
    {
        $tarefa = $this->tarefaBusiness->buscarTarefaParaIntegracaoPorId($tarefaDTO->id);

        $trelloCard = TrelloCardDTO::from([
            'idBoard' => $boardDTO->id,
            'desc'  => $tarefa->descricao,
            'name'  => $tarefa->titulo,
            'start' => $tarefa->inicio_estimado,
            'idList' => $listTituloAberta->id,
            'idMembers' => [$tarefa->responsavel->integracao->id_externo]
        ]);
        if($tarefa->integracao != null && $tarefa->integracao->id_externo != null){
            $trelloCard->id = $tarefa->integracao->id_externo;
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
