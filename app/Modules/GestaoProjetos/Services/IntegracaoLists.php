<?php

namespace App\Modules\GestaoProjetos\Services;

use App\Modules\GestaoProjetos\Config\TrelloConfig;
use App\Modules\GestaoProjetos\DTOs\TrelloBoardDTO;
use App\Modules\GestaoProjetos\DTOs\TrelloListDTO;
use App\Modules\GestaoProjetos\Libs\Trello\TrelloLists;

class IntegracaoLists
{
    public function __construct(
        private readonly TrelloLists $trelloListService
    )
    {
    }

    public function integrar( object $list, TrelloBoardDTO $boardDTO):TrelloListDTO
    {

        if($listDTO = $this->getListIfExists($list->value, $boardDTO->id)){
            return $listDTO;
        }
        $trelloList = TrelloListDTO::from([
            'name' => $list->value,
            'idBoard'   => $boardDTO->id
        ]);

        $list = $this->trelloListService->create($boardDTO->id, $trelloList);
        return $list;
    }

    private function getListIfExists(string $listName, string $boardId):?TrelloListDTO
    {
        return $this->trelloListService
                    ->get(['id' => $boardId])
                    ->where('name','=',$listName)
                    ->first();
    }
}
