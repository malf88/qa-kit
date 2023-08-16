<?php

namespace App\Modules\GestaoProjetos\Libs\Trello;


use App\Modules\GestaoProjetos\DTOs\TrelloBoardDTO;

class TrelloMyBoards extends AbstractTrello
{
    protected string $path = 'members/me/boards';
    public function get(mixed $parameters): mixed
    {
        return TrelloBoardDTO::collection($this->request('GET', []));
    }
}
