<?php

namespace App\Modules\GestaoProjetos\Models;

use App\Modules\Projetos\Models\Projeto as BaseModel;

class Projeto extends BaseModel
{

    public function tarefas()
    {
        return $this->hasMany(Tarefa::class);
    }
}
