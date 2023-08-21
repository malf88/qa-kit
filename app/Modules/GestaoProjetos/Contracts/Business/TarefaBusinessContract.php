<?php

namespace App\Modules\GestaoProjetos\Contracts\Business;

use App\Modules\GestaoProjetos\DTOs\TarefaDTO;
use Spatie\LaravelData\DataCollection;

interface TarefaBusinessContract
{
    public function listarTarefasComSprint(int $idProjeto, int $idEquipe): DataCollection;

    public function salvar(TarefaDTO $tarefaDTO): TarefaDTO;

    public function updateSprint(int $idTarefa, ?int $idSprint, int $idEquipe): bool;

    public function podeAlterarTarefa(int $idTarefa, int $idEquipe): bool;
}
