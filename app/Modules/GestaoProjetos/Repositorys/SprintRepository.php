<?php

namespace App\Modules\GestaoProjetos\Repositorys;

use App\Modules\GestaoProjetos\Contracts\Repositorys\SprintRepositoryContract;
use App\Modules\GestaoProjetos\DTOs\SprintDTO;
use App\Modules\GestaoProjetos\Models\Sprint;
use Spatie\LaravelData\DataCollection;

class SprintRepository implements SprintRepositoryContract
{


    public function listarSprints(int $idProjeto, int $idEquipe): DataCollection
    {
        return SprintDTO::collection(
            Sprint::select('sprints.*')
            ->join('projetos.projetos', 'sprints.projeto_id', '=', 'projetos.id')
            ->join('projetos.aplicacoes', 'projetos.aplicacao_id', '=', 'aplicacoes.id')
            ->join('projetos.aplicacoes_equipes', 'aplicacoes.id', '=', 'aplicacoes_equipes.aplicacao_id')
            ->where('sprints.projeto_id',$idProjeto)
            ->where('aplicacoes_equipes.equipe_id', $idEquipe)
            ->with(['projeto'])
            ->get());
    }

    public function salvar(SprintDTO $sprintDTO): SprintDTO
    {
        $sprint = new Sprint($sprintDTO->toArray());
        $sprint->save();
        return SprintDTO::from($sprint);
    }

    public function existeSprint(string $nome, int $idProjeto, int $idEquipe): bool
    {
        return Sprint::select('sprints.*')
            ->join('projetos.projetos', 'sprints.projeto_id', '=', 'projetos.id')
            ->join('projetos.aplicacoes', 'projetos.aplicacao_id', '=', 'aplicacoes.id')
            ->join('projetos.aplicacoes_equipes', 'aplicacoes.id', '=', 'aplicacoes_equipes.aplicacao_id')
            ->where('sprints.projeto_id',$idProjeto)
            ->where('aplicacoes_equipes.equipe_id', $idEquipe)
            ->where('sprints.nome', 'ILIKE', $nome)
            ->count() > 0;
    }

    public function buscarSprintPorNome(string $nome, int $idProjeto, int $idEquipe): ?SprintDTO
    {
        $sprint =  Sprint::select('sprints.*')
            ->join('projetos.projetos', 'sprints.projeto_id', '=', 'projetos.id')
            ->join('projetos.aplicacoes', 'projetos.aplicacao_id', '=', 'aplicacoes.id')
            ->join('projetos.aplicacoes_equipes', 'aplicacoes.id', '=', 'aplicacoes_equipes.aplicacao_id')
            ->where('sprints.projeto_id',$idProjeto)
            ->where('aplicacoes_equipes.equipe_id', $idEquipe)
            ->where('sprints.nome', 'ILIKE', $nome)
            ->with(['projeto', 'tarefas'])
            ->first();
        if(!$sprint) return null;
        return SprintDTO::from($sprint);

    }
}
