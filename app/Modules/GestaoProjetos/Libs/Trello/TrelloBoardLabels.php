<?php

namespace App\Modules\GestaoProjetos\Libs\Trello;


use App\Modules\GestaoProjetos\DTOs\TrelloCardDTO;
use App\Modules\GestaoProjetos\DTOs\TrelloLabelDTO;
use App\Modules\GestaoProjetos\DTOs\TrelloMemberDTO;

class TrelloBoardLabels extends AbstractTrello
{
    protected string $path = 'boards/{id}/labels';
    public function get(mixed $parameters): mixed
    {
        return
            TrelloLabelDTO::collection($this->request('GET', [],
                [
                    '{id}' => $parameters['id']
                ]
            )

        );
    }

    public function create(string $boardId, TrelloLabelDTO $trelloLabelDTO): TrelloLabelDTO
    {
        return TrelloLabelDTO::from($this->request('POST', $trelloLabelDTO->toArray(),['{id}' => $boardId]));
    }

}
