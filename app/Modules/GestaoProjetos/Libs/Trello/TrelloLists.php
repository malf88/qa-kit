<?php

namespace App\Modules\GestaoProjetos\Libs\Trello;

use App\Modules\GestaoProjetos\DTOs\TrelloCardDTO;
use App\Modules\GestaoProjetos\DTOs\TrelloBoardDTO;
use App\Modules\GestaoProjetos\DTOs\TrelloListDTO;
use Illuminate\Support\Collection;

class TrelloLists extends AbstractTrello
{
    protected string $path = 'boards/{id}/lists';
    public function get(mixed $parameters): mixed
    {
         TrelloListDTO::collection($this->request('GET', [],['{id}' => $parameters['id']]));

    }

}
