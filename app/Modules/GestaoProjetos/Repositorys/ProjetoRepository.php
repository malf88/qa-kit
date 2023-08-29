<?php

namespace App\Modules\GestaoProjetos\Repositorys;

use App\Modules\GestaoProjetos\Contracts\Repositorys\ProjetoRepositoryContract;
use App\Modules\GestaoProjetos\DTOs\ProjetoDTO;
use App\Modules\GestaoProjetos\Enums\TarefaStatusEnum;

use App\Modules\Projetos\Models\Projeto;
use App\Modules\Projetos\Repositorys\ProjetoRepository as BaseRepository;
use Spatie\LaravelData\DataCollection;

class ProjetoRepository extends BaseRepository implements ProjetoRepositoryContract
{
    public function buscarTodosPorEquipe(int $idEquipe): DataCollection
    {
        return ProjetoDTO::collection(
            Projeto::select('projetos.*')
                ->selectRaw('
                  COALESCE(
                    cast(((SELECT COUNT(id) FROM gestao_projetos.tarefas WHERE status = ? AND projeto_id = projetos.id) * 100) as numeric) /
                    cast(NULLIF((SELECT COUNT(id) FROM gestao_projetos.tarefas WHERE projeto_id = projetos.id),0) as numeric)
                   ,0) as andamento',[TarefaStatusEnum::CONCLUIDA->value])
                ->join('projetos.aplicacoes','aplicacoes.id','=','projetos.aplicacao_id')
                ->join('projetos.aplicacoes_equipes','aplicacoes.id','=','aplicacoes_equipes.aplicacao_id')
                ->where('equipe_id',$idEquipe)
                ->with(['aplicacao'])
                ->get()
        );
    }

    public function buscarPorIdProjeto(int $idProjeto, int $idEquipe): ?ProjetoDTO
    {
        $projeto = Projeto::select('projetos.*')
            ->selectRaw('
                  COALESCE(
                    cast(((SELECT COUNT(id) FROM gestao_projetos.tarefas WHERE status = ? AND projeto_id = projetos.id) * 100) as numeric) /
                    cast(NULLIF((SELECT COUNT(id) FROM gestao_projetos.tarefas WHERE projeto_id = projetos.id),0) as numeric)
                   ,0) as andamento',[TarefaStatusEnum::CONCLUIDA->value])
            ->join('projetos.aplicacoes','aplicacoes.id','=','projetos.aplicacao_id')
            ->join('projetos.aplicacoes_equipes','aplicacoes.id','=','aplicacoes_equipes.aplicacao_id')
            ->where('equipe_id',$idEquipe)
            ->where('projetos.id', $idProjeto)
            ->with(['aplicacao'])
            ->first();
        return $projeto != null ? ProjetoDTO::from($projeto): null;
    }
}
