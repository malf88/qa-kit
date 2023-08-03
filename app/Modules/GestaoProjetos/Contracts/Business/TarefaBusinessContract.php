<?php

namespace App\Modules\GestaoProjetos\Contracts\Business;

use App\Modules\GestaoProjetos\DTOs\TarefaDTO;

interface TarefaBusinessContract
{
    public function salvar(TarefaDTO $tarefaDTO): TarefaDTO;
}
