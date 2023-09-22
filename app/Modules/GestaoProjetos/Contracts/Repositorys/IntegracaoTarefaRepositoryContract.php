<?php

namespace App\Modules\GestaoProjetos\Contracts\Repositorys;

use App\Modules\GestaoProjetos\DTOs\IntegracaoTarefaDTO;
use App\Modules\GestaoProjetos\DTOs\IntegracaoUsuarioDTO;

interface IntegracaoTarefaRepositoryContract
{
    public function integrar(IntegracaoTarefaDTO $integracaoDTO): IntegracaoTarefaDTO;
}
