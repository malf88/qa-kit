<?php

namespace App\Modules\GestaoProjetos\Contracts\Business;

use App\Modules\GestaoProjetos\DTOs\ProjetoDTO;
use App\Modules\Projetos\Contracts\Business\ProjetoBusinessContract as BaseBusinessContract;

interface ProjetoBusinessContract extends BaseBusinessContract
{
    public function buscarPorIdProjeto(int $idProjeto, int $idEquipe): ?ProjetoDTO;
}
