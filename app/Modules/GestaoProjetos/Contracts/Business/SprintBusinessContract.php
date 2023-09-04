<?php

namespace App\Modules\GestaoProjetos\Contracts\Business;

use App\Modules\GestaoProjetos\DTOs\SprintDTO;
use App\Modules\GestaoProjetos\DTOs\TarefaDTO;
use Spatie\LaravelData\DataCollection;

interface SprintBusinessContract
{
    public function listarSprints(int $idProjeto, int $idEquipe): DataCollection;
    public function salvar(SprintDTO $sprintDTO): SprintDTO;
    public function existeSprint(string $nome, int $idProjeto, int $idEquipe): bool;
    public function buscarSprintPorNome(string $nome, int $idProjeto, int $idEquipe): ?SprintDTO;
}
