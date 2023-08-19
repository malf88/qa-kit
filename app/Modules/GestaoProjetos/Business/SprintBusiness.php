<?php

namespace App\Modules\GestaoProjetos\Business;

use App\Modules\GestaoProjetos\Contracts\Business\SprintBusinessContract;
use App\Modules\GestaoProjetos\Contracts\Repositorys\SprintRepositoryContract;
use App\System\Impl\BusinessAbstract;
use Spatie\LaravelData\DataCollection;

class SprintBusiness extends BusinessAbstract implements SprintBusinessContract
{

    public function __construct(
        private SprintRepositoryContract $tarefaRepository
    )
    {
    }

    public function listarSprints(int $idProjeto, int $idEquipe): DataCollection
    {
        return $this->tarefaRepository->listarSprints($idProjeto, $idEquipe);
    }
}
