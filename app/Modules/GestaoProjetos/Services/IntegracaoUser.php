<?php

namespace App\Modules\GestaoProjetos\Services;

use App\Modules\GestaoProjetos\Config\TrelloConfig;
use App\Modules\GestaoProjetos\DTOs\IntegracaoUsuarioDTO;
use App\Modules\GestaoProjetos\DTOs\TrelloBoardDTO;
use App\Modules\GestaoProjetos\DTOs\TrelloMemberDTO;
use App\Modules\GestaoProjetos\DTOs\UserDTO;
use App\Modules\GestaoProjetos\Libs\Trello\TrelloBoardMembers;
use App\System\Contracts\Business\IntegracaoBusinessContract;
use App\System\Contracts\Repository\UserRepositoryContract;

class IntegracaoUser
{
    public function __construct(
        private readonly TrelloBoardMembers $trelloBoardMemberService,
        private readonly IntegracaoBusinessContract $integracaoUserBusiness,
        private readonly UserRepositoryContract $userRepository
    )
    {
    }

    public function integrar(UserDTO $userDTO, TrelloBoardDTO $boardDTO):TrelloMemberDTO
    {

        $userDTO = $this->userRepository->buscarPorId($userDTO->id);
        if($userDTO->integracao?->id_externo != null){
            return TrelloMemberDTO::from(json_decode($userDTO->integracao->retorno));
        }
        $user = $this->trelloBoardMemberService->addByEmail($boardDTO->id, TrelloMemberDTO::from(['email' => $userDTO->email]));
        $integracaoUser = IntegracaoUsuarioDTO::from([
            'user_id' => $userDTO->id,
            'id_externo'    => $user->id,
            'retorno'   => json_encode($user)
        ]);

        $this->integracaoUserBusiness->registrarIntegracao($integracaoUser);
        return $user;
    }
}
