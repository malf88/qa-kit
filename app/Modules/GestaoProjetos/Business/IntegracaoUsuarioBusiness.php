<?php

namespace App\Modules\GestaoProjetos\Business;

use App\Modules\GestaoProjetos\Contracts\Repositorys\IntegracaoUsuarioRepositoryContract;
use App\Modules\GestaoProjetos\Repositorys\IntegracaoUsuarioRepository;
use App\System\Contracts\Business\IntegracaoBusinessContract;
use App\System\Utils\DTO;

class IntegracaoUsuarioBusiness implements IntegracaoBusinessContract
{
    public function __construct(
        private readonly IntegracaoUsuarioRepositoryContract $integracaoUsuarioRepository
    )
    {
    }

    public function registrarIntegracao(DTO $integracaoDTO): bool
    {
        $this->integracaoUsuarioRepository->integrar($integracaoDTO);
        return true;
    }
}
