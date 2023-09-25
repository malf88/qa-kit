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

class Tarefa extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'gestao_projetos.tarefas';

    protected $fillable = [
        'titulo',
        'descricao',
        'status',
        'data_arquivamento',
        'inicio_estimado',
        'termino_estimado',
        'projeto_id',
        'responsavel_id',
        'sprint_id'

    ];


    public function projeto()
    {
        return $this->belongsTo(Projeto::class);

    }
    public function responsavel()
    {
        return $this->belongsTo(User::class);

    }

    public function sprint()
    {
        return $this->belongsTo(Sprint::class);

    }

    public function comentarios()
    {
        return $this->hasMany(ComentarioTarefa::class);

    }
    public function auditorias()
    {
        return $this->hasMany(AuditoriaTarefa::class);

    }

    public function integracao()
    {
        return $this->hasOne(IntegracaoTarefa::class);
    }
}
