<?php

namespace App\Modules\GestaoProjetos\Services;

use App\Modules\GestaoProjetos\DTOs\IntegracaoUsuarioDTO;
use App\Modules\GestaoProjetos\DTOs\ProjetoDTO;
use App\Modules\GestaoProjetos\DTOs\TrelloBoardDTO;
use App\Modules\GestaoProjetos\DTOs\TrelloListDTO;
use App\Modules\GestaoProjetos\Libs\Trello\TrelloBoards;
use App\Modules\GestaoProjetos\Libs\Trello\TrelloLists;
use App\System\DTOs\UserDTO;

class IntegracaoLists
{
    public function integrar( object $list, TrelloBoardDTO $boardDTO):TrelloListDTO
    {
        $trelloListService = new TrelloLists(
            'ATTAe8d2bec2b9b0a5874bb88ccda0d6d0c5d187feea9d6e15c6a7ef643276d48ba8D8DEF6DB',
            '4af9dd9f228be32b068c307a01ee268f'
        );
        $trelloList = TrelloListDTO::from([
            'name' => $list->value,
            'idBoard'   => $boardDTO->id
        ]);

        $list = $trelloListService->create($boardDTO->id, $trelloList);
        return $list;
    }
}
