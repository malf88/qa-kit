<?php

namespace App\Modules\Projetos\Business;

use App\Modules\Projetos\Contracts\TotaisTestesBusinessContract;
use App\Modules\Projetos\Contracts\TotaisTestesRepositoryContract;
use App\Modules\Projetos\DTOs\TotaisTestesDTO;
use App\System\Impl\BusinessAbstract;

class TotaisTestesBusiness extends BusinessAbstract implements TotaisTestesBusinessContract
{
    public function __construct(
        private readonly TotaisTestesRepositoryContract $totaisTestesRepository
    )
    {
    }

    public function buscarTotaisTestes(): TotaisTestesDTO
    {
        return $this->totaisTestesRepository->buscarTotaisTestes();
    }
}
