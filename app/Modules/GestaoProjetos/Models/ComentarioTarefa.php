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

class ComentarioTarefa extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'gestao_projetos.comentarios_tarefa';

    protected $fillable = [
        'descricao',
        'tarefa_id',
        'user_id'
    ];


    public function tarefa()
    {
        return $this->belongsTo(Tarefa::class);

    }
    public function user()
    {
        return $this->belongsTo(User::class);

    }
}
