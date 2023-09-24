<?php

namespace App\Modules\GestaoProjetos\Business;

use App\Modules\GestaoProjetos\Contracts\Repositorys\IntegracaoTarefaRepositoryContract;
use App\Modules\GestaoProjetos\Contracts\Repositorys\IntegracaoUsuarioRepositoryContract;
use App\Modules\GestaoProjetos\Repositorys\IntegracaoUsuarioRepository;
use App\System\Contracts\Business\IntegracaoBusinessContract;
use App\System\Utils\DTO;

class IntegracaoTarefaBusiness implements IntegracaoBusinessContract
{
    public function __construct(
        private readonly IntegracaoTarefaRepositoryContract $integracaoTarefaRepository
    )
    {
    }

    public function registrarIntegracao(DTO $integracaoDTO): bool
    {
        $this->integracaoTarefaRepository->integrar($integracaoDTO);
        return true;
    }
}
