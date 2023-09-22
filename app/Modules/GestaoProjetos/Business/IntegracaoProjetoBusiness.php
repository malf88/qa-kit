<?php

namespace App\Modules\GestaoProjetos\Business;

use App\Modules\GestaoProjetos\Contracts\Repositorys\IntegracaoProjetoRepositoryContract;
use App\Modules\GestaoProjetos\Contracts\Repositorys\IntegracaoUsuarioRepositoryContract;
use App\Modules\GestaoProjetos\Repositorys\IntegracaoUsuarioRepository;
use App\System\Contracts\Business\IntegracaoBusinessContract;
use App\System\Utils\DTO;

class IntegracaoProjetoBusiness implements IntegracaoBusinessContract
{
    public function __construct(
        private readonly IntegracaoProjetoRepositoryContract $integracaoProjetoRepository
    )
    {
    }

    public function registrarIntegracao(DTO $integracaoDTO): bool
    {
        $this->integracaoProjetoRepository->integrar($integracaoDTO);
        return true;
    }
}
