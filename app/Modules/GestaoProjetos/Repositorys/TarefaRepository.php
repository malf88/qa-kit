<?php

namespace App\Modules\GestaoProjetos\Repositorys;

use App\Modules\GestaoProjetos\Contracts\Repositorys\TarefaRepositoryContract;
use App\Modules\GestaoProjetos\DTOs\TarefaDTO;
use App\Modules\GestaoProjetos\Models\Tarefa;

class TarefaRepository implements TarefaRepositoryContract
{

    public function salvar(TarefaDTO $tarefaDTO): TarefaDTO
    {
        $tarefa = new Tarefa($tarefaDTO->toArray());
        $tarefa->save();
        return TarefaDTO::from($tarefa);
    }
}
