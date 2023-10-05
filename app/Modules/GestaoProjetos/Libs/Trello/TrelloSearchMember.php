<?php

namespace App\Modules\GestaoProjetos\Libs\Trello;


use App\Modules\GestaoProjetos\DTOs\TrelloCardDTO;
use App\Modules\GestaoProjetos\DTOs\TrelloMemberDTO;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class TrelloSearchMember extends AbstractTrello
{
    protected string $path = 'search/members';
    public function get(mixed $parameters): mixed
    {
        return TrelloMemberDTO::collection(
            $this->request('GET', $parameters)
        );
    }



}
