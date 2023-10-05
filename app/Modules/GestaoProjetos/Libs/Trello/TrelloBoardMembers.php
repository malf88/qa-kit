<?php

namespace App\Modules\GestaoProjetos\Libs\Trello;


use App\Modules\GestaoProjetos\Config\TrelloConfig;
use App\Modules\GestaoProjetos\DTOs\TrelloCardDTO;
use App\Modules\GestaoProjetos\DTOs\TrelloMemberDTO;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

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

        $this->request('PUT', $trelloMemberDTO->toArray(),['{id}' => $boardId, '{idMember}' => '']);
        $memberService = new TrelloSearchMember(new TrelloConfig());
        Log::info($memberService->get(['query' => $trelloMemberDTO->email])->first());
        return $memberService->get(['query' => $trelloMemberDTO->email])->first();
    }

    public function delete(string $boardId, TrelloMemberDTO $trelloMemberDTO): TrelloMemberDTO
    {
        return TrelloMemberDTO::from($this->request('DELETE', [],[
            '{id}' => $boardId,
            '{idMember}' => $trelloMemberDTO->id
        ]));
    }

}
