<?php

namespace App\Modules\GestaoProjetos\Contracts\Repositorys;

use App\Modules\GestaoProjetos\DTOs\IntegracaoProjetoDTO;
use App\Modules\GestaoProjetos\DTOs\IntegracaoTarefaDTO;

interface IntegracaoProjetoRepositoryContract
{
    public function integrar(IntegracaoProjetoDTO $integracaoDTO): IntegracaoProjetoDTO;
}
