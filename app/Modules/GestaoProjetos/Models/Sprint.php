<?php

namespace App\Modules\GestaoProjetos\Models;

use App\Modules\Projetos\Models\Aplicacao;
use App\Modules\Projetos\Models\Projeto;
use App\System\DTOs\EquipeDTO;
use App\System\Models\Equipe;
use App\System\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sprint extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'gestao_projetos.sprints';

    protected $fillable = [
        'nome',
        'inicio',
        'termino',
        'projeto_id'
    ];


    public function projeto()
    {
        return $this->belongsTo(Projeto::class);

    }

    public function tarefas()
    {
        return $this->hasMany(Tarefa::class);

    }
}
