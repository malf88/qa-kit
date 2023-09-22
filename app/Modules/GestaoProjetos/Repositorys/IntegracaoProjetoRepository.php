<?php

namespace App\Modules\GestaoProjetos\Repositorys;

use App\Modules\GestaoProjetos\Contracts\Repositorys\IntegracaoProjetoRepositoryContract;
use App\Modules\GestaoProjetos\DTOs\IntegracaoProjetoDTO;
use App\Modules\GestaoProjetos\DTOs\IntegracaoTarefaDTO;
use App\Modules\GestaoProjetos\Models\IntegracaoProjeto;
use App\Modules\GestaoProjetos\Models\IntegracaoTarefa;

class IntegracaoProjetoRepository implements IntegracaoProjetoRepositoryContract
{

    public function integrar(IntegracaoProjetoDTO $integracaoDTO): IntegracaoProjetoDTO
    {
        $integracaoProjeto = new IntegracaoProjeto($integracaoDTO->toArray());
        $integracaoProjeto->save();
        return IntegracaoProjetoDTO::from($integracaoProjeto);
    }
}
