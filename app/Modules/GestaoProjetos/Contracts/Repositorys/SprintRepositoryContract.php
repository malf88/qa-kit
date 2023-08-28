<?php

namespace App\Modules\GestaoProjetos\Contracts\Repositorys;

use App\Modules\GestaoProjetos\DTOs\ProjetoDTO;
use App\Modules\GestaoProjetos\DTOs\SprintDTO;
use Spatie\LaravelData\DataCollection;

interface SprintRepositoryContract
{
    public function listarSprints(int $idProjeto, int $idEquipe): DataCollection;
    public function salvar(SprintDTO $sprintDTO): SprintDTO;
}
