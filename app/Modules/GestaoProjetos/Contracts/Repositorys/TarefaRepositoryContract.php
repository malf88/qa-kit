<?php

namespace App\Modules\GestaoProjetos\Contracts\Repositorys;

use App\Modules\GestaoProjetos\DTOs\TarefaDTO;

interface TarefaRepositoryContract
{
    public function salvar(TarefaDTO $tarefaDTO): TarefaDTO;

}
