<?php

namespace App\Modules\GestaoProjetos\Models;

use App\Modules\Projetos\Models\Projeto as BaseModel;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Projeto extends BaseModel
{

    public function tarefas()
    {
        return $this->hasMany(Tarefa::class);
    }
    protected function getTrelloIdAttribute(): string
    {
        return $this->integracao->id_externo;
    }
    public function integracao()
    {
        return $this->hasOne(IntegracaoProjeto::class);
    }
}
