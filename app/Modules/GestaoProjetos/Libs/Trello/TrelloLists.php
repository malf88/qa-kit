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
         return TrelloListDTO::collection($this->request('GET', [],['{id}' => $parameters['id']]));

    }
    public function create(string $idBoard, TrelloListDTO $trelloListDTO): mixed
    {
        return TrelloListDTO::from($this->request('POST', $trelloListDTO->toArray(),['{id}' => $idBoard]));

    }

}
