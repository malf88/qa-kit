<?php

namespace App\Modules\GestaoProjetos\Repositorys;

use App\Modules\GestaoProjetos\Contracts\Repositorys\TarefaRepositoryContract;
use App\Modules\GestaoProjetos\DTOs\TarefaDTO;
use App\Modules\GestaoProjetos\DTOs\TarefaSprintDTO;
use App\Modules\GestaoProjetos\Models\Tarefa;
use App\System\Business\UserBusiness;
use App\System\Contracts\Business\UserBusinessContract;
use Illuminate\Support\Facades\DB;
use Spatie\LaravelData\DataCollection;

class TarefaRepository implements TarefaRepositoryContract
{
    public function __construct(
    )
    {
    }

    public function salvar(TarefaDTO $tarefaDTO): TarefaDTO
    {
        $tarefa = new Tarefa($tarefaDTO->toArray());
        $tarefa->save();
        return TarefaDTO::from($tarefa);
    }

    public function listarTarefasComSprint(int $idProjeto, int $idEquipe): DataCollection
    {
        $tarefas = DB::select('SELECT
                                        sprint_id,
                                        tarefa_id,
                                        st.descricao,
                                        projeto_id,
                                        st.inicio,
                                        st.termino,
                                        st.status,
                                        st.id_responsavel as responsavel,
                                        trello_id
                                    FROM
                                        (SELECT
                                             s.id as sprint_id,
                                             null as tarefa_id,
                                             s.nome as descricao,
                                             s.projeto_id,
                                             s.inicio,
                                             s.termino,
                                             null as id_responsavel,
                                             null as status,
                                             null as trello_id
                                        FROM gestao_projetos.sprints s
                                        UNION
                                        SELECT
                                            t.sprint_id,
                                            t.id,
                                            t.titulo,
                                            t.projeto_id,
                                            t.inicio_estimado,
                                            t.termino_estimado,
                                            u.id,
                                            t.status,
                                            i.id_externo
                                        FROM gestao_projetos.tarefas t
                                            LEFT JOIN users u on u.id = t.responsavel_id
                                            LEFT JOIN integracoes.integracoes_tarefas i ON i.tarefa_id = t.id) as st
                                            JOIN projetos.projetos p on p.id = st.projeto_id
                                            JOIN projetos.aplicacoes a ON p.aplicacao_id = a.id
                                            JOIN projetos.aplicacoes_equipes ae ON ae.aplicacao_id = a.id
                                        WHERE projeto_id = ? AND ae.equipe_id = ?
                                    ORDER BY sprint_id, tarefa_id is not null, inicio',[$idProjeto, $idEquipe]);

        return TarefaSprintDTO::collection($tarefas);
    }

    public function updateTarefa(TarefaDTO $tarefaDTO, int $idEquipe): bool
    {
        $tarefa = Tarefa::find($tarefaDTO->id);
        $tarefa->id = $tarefaDTO->id;
        $tarefa->titulo = $tarefaDTO->titulo ?? $tarefa->titulo;
        $tarefa->descricao = $tarefaDTO->descricao ?? $tarefa->descricao;
        $tarefa->inicio_estimado = $tarefaDTO->inicio_estimado ?? $tarefa->inicio_estimado;
        $tarefa->termino_estimado = $tarefaDTO->termino_estimado ?? $tarefa->termino_estimado;
        $tarefa->sprint_id = $tarefaDTO->sprint_id ?? $tarefa->sprint_id;
        $tarefa->responsavel_id = $tarefaDTO->responsavel_id ?? $tarefa->responsavel_id ;

        return $tarefa->update();

    }

    public function buscarTarefaPorId(int $idTarefa, int $idEquipe): ?TarefaDTO
    {
        $tarefa = Tarefa::select('tarefas.*')
            ->join('projetos.projetos', 'projetos.id', '=', 'tarefas.projeto_id')
            ->join('projetos.aplicacoes', 'projetos.aplicacao_id', '=', 'aplicacoes.id')
            ->join('projetos.aplicacoes_equipes', 'aplicacoes.id', '=', 'aplicacoes_equipes.aplicacao_id')
            ->where('equipe_id', $idEquipe)
            ->where('tarefas.id', $idTarefa)
            ->first();
        return ($tarefa != null) ? TarefaDTO::from($tarefa) : $tarefa;
    }

    public function existeTarefaPorTitulo(string $titulo, int $idProjeto, int $idEquipe): bool
    {
        return Tarefa::join('projetos.projetos', 'projetos.id', '=', 'tarefas.projeto_id')
            ->join('projetos.aplicacoes', 'projetos.aplicacao_id', '=', 'aplicacoes.id')
            ->join('projetos.aplicacoes_equipes', 'aplicacoes.id', '=', 'aplicacoes_equipes.aplicacao_id')
            ->where('equipe_id', $idEquipe)
            ->where('projetos.id', $idProjeto)
            ->where('tarefas.titulo','ILIKE', $titulo)
            ->count() > 0;

    }
}
