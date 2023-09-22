<?php

namespace App\Modules\GestaoProjetos\Contracts\Repositorys;

use App\Modules\GestaoProjetos\DTOs\IntegracaoUsuarioDTO;

interface IntegracaoUsuarioRepositoryContract
{
    public function integrar(IntegracaoUsuarioDTO $integracaoDTO): IntegracaoUsuarioDTO;
}
