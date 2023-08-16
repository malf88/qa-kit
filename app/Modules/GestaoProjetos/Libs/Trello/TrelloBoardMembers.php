<?php

namespace App\Modules\GestaoProjetos\Libs\Trello;


use App\Modules\GestaoProjetos\DTOs\TrelloCardDTO;
use App\Modules\GestaoProjetos\DTOs\TrelloMemberDTO;

class TrelloBoardMembers extends AbstractTrello
{
    protected string $path = 'boards/{id}/members/{idMember}';
    public function get(mixed $parameters): mixed
    {
        return TrelloMemberDTO::collection(
            $this->request('GET', [],
                [
                    '{id}' => $parameters['id'],
                    '{idMember}' => ''
                ]
            )
        );
    }

    public function addByEmail(string $boardId, TrelloMemberDTO $trelloMemberDTO): TrelloMemberDTO
    {
        return TrelloMemberDTO::from($this->request('PUT', $trelloMemberDTO->toArray(),['{id}' => $boardId, '{idMember}' => '']));
    }

    public function delete(string $boardId, TrelloMemberDTO $trelloMemberDTO): TrelloMemberDTO
    {
        return TrelloMemberDTO::from($this->request('DELETE', [],[
            '{id}' => $boardId,
            '{idMember}' => $trelloMemberDTO->id
        ]));
    }

}
