<?php

namespace App\Modules\GestaoProjetos\Libs\Trello;


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
        $users = $this->get(['id' => $boardId]);

        $this->request('PUT', $trelloMemberDTO->toArray(),['{id}' => $boardId, '{idMember}' => '']);

        $newUsers =$this->get(['id' => $boardId]);

        $usersId = [];
        $users->each(function (TrelloMemberDTO $item, $key) use(&$usersId) {
            $usersId[] = $item->id;
        });

        $newsUsersId = [];
        $newUsers->each(function (TrelloMemberDTO $item, $key) use(&$newsUsersId) {
            $newsUsersId[] = $item->id;
        });
        $user = array_diff($newsUsersId, $usersId);
        return $newUsers->where('id','=',$user[0])->first();
    }

    public function delete(string $boardId, TrelloMemberDTO $trelloMemberDTO): TrelloMemberDTO
    {
        return TrelloMemberDTO::from($this->request('DELETE', [],[
            '{id}' => $boardId,
            '{idMember}' => $trelloMemberDTO->id
        ]));
    }

}
