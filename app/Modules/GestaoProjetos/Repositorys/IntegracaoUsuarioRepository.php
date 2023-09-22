<?php

namespace App\Modules\GestaoProjetos\Repositorys;

use App\Modules\GestaoProjetos\Contracts\Repositorys\IntegracaoUsuarioRepositoryContract;
use App\Modules\GestaoProjetos\DTOs\IntegracaoUsuarioDTO;
use App\Modules\GestaoProjetos\Models\IntegracaoUsuario;

class IntegracaoUsuarioRepository implements IntegracaoUsuarioRepositoryContract
{

    public function integrar(IntegracaoUsuarioDTO $integracaoDTO): IntegracaoUsuarioDTO
    {
        $integracaoUsuario = new IntegracaoUsuario($integracaoDTO->toArray());
        $integracaoUsuario->save();
        return IntegracaoUsuarioDTO::from($integracaoUsuario);
    }
}
