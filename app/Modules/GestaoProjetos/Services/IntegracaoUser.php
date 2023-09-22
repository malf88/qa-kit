<?php

namespace App\Modules\GestaoProjetos\Services;

use App\Modules\GestaoProjetos\DTOs\IntegracaoUsuarioDTO;
use App\Modules\GestaoProjetos\DTOs\ProjetoDTO;
use App\Modules\GestaoProjetos\DTOs\TrelloBoardDTO;
use App\Modules\GestaoProjetos\DTOs\TrelloMemberDTO;
use App\Modules\GestaoProjetos\Libs\Trello\TrelloBoardMembers;
use App\Modules\GestaoProjetos\Libs\Trello\TrelloBoards;
use App\System\DTOs\UserDTO;

class IntegracaoUser
{
    public function integrar(UserDTO $userDTO, TrelloBoardDTO $boardDTO):TrelloMemberDTO
    {
        $trelloUserService = new TrelloBoardMembers(
            'ATTAe8d2bec2b9b0a5874bb88ccda0d6d0c5d187feea9d6e15c6a7ef643276d48ba8D8DEF6DB',
            '4af9dd9f228be32b068c307a01ee268f'
        );
//            $user = $trelloUserService->get(['id' => $board->id]);
        $user = $trelloUserService->addByEmail($boardDTO->id, TrelloMemberDTO::from(['email' => $userDTO->email]));

        return $user;
    }
}
