<?php

namespace App\Modules\GestaoProjetos\Libs\Trello;

use App\Modules\GestaoProjetos\DTOs\TrelloCardDTO;
use App\Modules\GestaoProjetos\DTOs\TrelloBoardDTO;
use Illuminate\Support\Collection;

class TrelloCards extends AbstractTrello
{
    protected string $path = 'cards/{id}';
    public function get(mixed $parameters): mixed
    {
        return TrelloCardDTO::from($this->request('GET', [],['{id}' => $parameters['id']]));
    }

    public function create(TrelloCardDTO $trelloCardDTO): TrelloCardDTO
    {
        return TrelloCardDTO::from($this->request('POST', $trelloCardDTO->toArray(),['{id}' => '']));
    }

    public function update(TrelloCardDTO $trelloCardDTO): TrelloCardDTO
    {
        return TrelloCardDTO::from($this->request('PUT', $trelloCardDTO->toArray(),['{id}' => $trelloCardDTO->id]));
    }

}
