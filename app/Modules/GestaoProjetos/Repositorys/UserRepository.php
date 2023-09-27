<?php

namespace App\Modules\GestaoProjetos\Repositorys;

use App\System\Contracts\Repository\UserRepositoryContract;
use App\System\DTOs\EquipeDTO;
use App\Modules\GestaoProjetos\DTOs\UserDTO;
use App\System\Repositorys\UserRepository as BaseRepository;
use App\Modules\GestaoProjetos\Models\User;

class UserRepository extends BaseRepository implements UserRepositoryContract
{
    public function buscarPorId(int $userId): ?UserDTO
    {
        $user = User::where('id', $userId)
                    ->with(['roles','integracao'])
                    ->first();

        if($user != null){
            $userDTO = UserDTO::from($user);
            $userDTO->equipes = EquipeDTO::collection($user->equipes);
            return $userDTO;
        }
        return null;
    }

}
