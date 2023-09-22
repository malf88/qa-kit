<?php

namespace App\Modules\GestaoProjetos\Services;

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
use App\System\DTOs\UserDTO;

class IntegracaoCard
{
    public function integrar(TarefaDTO $tarefaDTO, TrelloBoardDTO $boardDTO, TrelloListDTO $listTituloAberta):TrelloCardDTO
    {
        $trelloCardService = new TrelloCards(
            'ATTAe8d2bec2b9b0a5874bb88ccda0d6d0c5d187feea9d6e15c6a7ef643276d48ba8D8DEF6DB',
            '4af9dd9f228be32b068c307a01ee268f'
        );
        $trelloCard = TrelloCardDTO::from([
            'idBoard' => $boardDTO->id,
            'desc'  => $tarefaDTO->descricao,
            'name'  => $tarefaDTO->titulo,
            'start' => $tarefaDTO->inicio_estimado,
            'idList' => $listTituloAberta->id

        ]);

       return $trelloCardService->create($trelloCard);

    }
}
