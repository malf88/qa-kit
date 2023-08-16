<?php

namespace App\Modules\GestaoProjetos\Libs\Trello;

use App\Modules\GestaoProjetos\DTOs\TrelloBoardDTO;
use Illuminate\Support\Collection;

class TrelloBoards extends AbstractTrello
{
    protected string $path = 'boards/{id}';
    public function get(mixed $parameters): mixed
    {
        //dd($this->request('GET', [],['{id}' => $parameters['id']]));
        return TrelloBoardDTO::from($this->request('GET', [],['{id}' => $parameters['id']]));
    }

    public function create(TrelloBoardDTO $trelloBoardDTO):TrelloBoardDTO
    {
        return TrelloBoardDTO::from($this->request('POST', $trelloBoardDTO->toArray(), ['{id}' => ''] ));
    }

    public function update(TrelloBoardDTO $trelloBoardDTO):TrelloBoardDTO
    {
        return TrelloBoardDTO::from($this->request('PUT', $trelloBoardDTO->toArray(), ['{id}' => $trelloBoardDTO->id] ));
    }

    public function cards(TrelloBoardDTO $trelloBoardDTO): mixed
    {
        //dd($this->request('GET', [],['{id}' => $parameters['id']]));

        return dd($this->request('GET', [],['{id}' => $trelloBoardDTO->id]));
    }
}
