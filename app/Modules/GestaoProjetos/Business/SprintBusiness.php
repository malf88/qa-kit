<?php

namespace App\Modules\GestaoProjetos\Business;

use App\Modules\GestaoProjetos\Contracts\Business\SprintBusinessContract;
use App\Modules\GestaoProjetos\Contracts\Repositorys\SprintRepositoryContract;
use App\Modules\GestaoProjetos\DTOs\SprintDTO;
use App\System\Impl\BusinessAbstract;
use Spatie\LaravelData\DataCollection;

class SprintBusiness extends BusinessAbstract implements SprintBusinessContract
{

    public function __construct(
        private SprintRepositoryContract $sprintRepository
    )
    {
    }

    public function listarSprints(int $idProjeto, int $idEquipe): DataCollection
    {
        return $this->sprintRepository->listarSprints($idProjeto, $idEquipe);
    }

    public function salvar(SprintDTO $sprintDTO): SprintDTO
    {
        return $this->sprintRepository->salvar($sprintDTO);
    }
}
