<?php

namespace App\Modules\GestaoProjetos\Contracts\Repositorys;

use App\Modules\GestaoProjetos\DTOs\TarefaDTO;
use Spatie\LaravelData\DataCollection;

interface TarefaRepositoryContract
{
    public function salvar(TarefaDTO $tarefaDTO): TarefaDTO;
    public function listarTarefasComSprint(int $idProjeto, int $idEquipe): DataCollection;
    public function updateSprint(int $idTarefa, ?int $idSprint):bool;
    public function buscarTarefaPorId(int $idTarefa, int $idEquipe):?TarefaDTO;

}
