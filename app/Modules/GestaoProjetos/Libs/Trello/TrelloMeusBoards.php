<?php

namespace App\Modules\GestaoProjetos\Libs\Trello;

use Illuminate\Support\Collection;

class TrelloMeusBoards extends AbstractTrello
{
    protected string $path = 'members/me/boards';
    public function send(mixed $parameters): mixed
    {
        return Collection::make($this->request('GET', []));
    }
}
