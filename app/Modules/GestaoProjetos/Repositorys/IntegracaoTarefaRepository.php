<?php

namespace App\Modules\GestaoProjetos\Repositorys;

use App\Modules\GestaoProjetos\Contracts\Repositorys\IntegracaoTarefaRepositoryContract;
use App\Modules\GestaoProjetos\DTOs\IntegracaoTarefaDTO;
use App\Modules\GestaoProjetos\DTOs\IntegracaoUsuarioDTO;
use App\Modules\GestaoProjetos\Models\IntegracaoTarefa;
use App\Modules\GestaoProjetos\Models\IntegracaoUsuario;

class IntegracaoTarefaRepository implements IntegracaoTarefaRepositoryContract
{

    public function integrar(IntegracaoTarefaDTO $integracaoDTO): IntegracaoTarefaDTO
    {
        $integracaoTarefa = new IntegracaoTarefa($integracaoDTO->toArray());
        $integracaoTarefa->save();
        return IntegracaoTarefaDTO::from($integracaoTarefa);
    }
}
