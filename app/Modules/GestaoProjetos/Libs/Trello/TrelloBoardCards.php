<?php

namespace App\Modules\GestaoProjetos\Libs\Trello;

use App\Modules\GestaoProjetos\DTOs\TrelloCardDTO;
use App\Modules\GestaoProjetos\DTOs\TrelloBoardDTO;
use Illuminate\Support\Collection;

class TrelloBoardCards extends AbstractTrello
{
    protected string $path = 'boards/{id}/cards';
    public function get(mixed $parameters): mixed
    {
        return TrelloCardDTO::collection($this->request('GET', [],['{id}' => $parameters['id']]));
    }

}
