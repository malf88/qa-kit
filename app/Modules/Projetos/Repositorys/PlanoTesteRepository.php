<?php

namespace App\Modules\Projetos\Repositorys;

use App\Modules\Projetos\Contracts\Repository\PlanoTesteRepositoryContract;
use App\Modules\Projetos\DTOs\ConsultaPlanoTesteDTO;
use App\Modules\Projetos\DTOs\PlanoTesteDTO;
use App\Modules\Projetos\Models\PlanoTeste;
use Illuminate\Support\Facades\DB;
use Spatie\LaravelData\DataCollection;

class PlanoTesteRepository implements PlanoTesteRepositoryContract
{

    public function buscarPlanosTestePorProjeto(int $idProjeto, int $idEquipe): DataCollection
    {
        return PlanoTesteDTO::collection(
            PlanoTeste::select('planos_teste.*')
                ->join('projetos.projetos','projetos.id','=','planos_teste.projeto_id')
                ->join('projetos.aplicacoes','aplicacoes.id','=','projetos.aplicacao_id')
                ->join('projetos.aplicacoes_equipes','aplicacoes.id','=','aplicacoes_equipes.aplicacao_id')
                ->where('equipe_id',$idEquipe)
                ->where('projeto_id',$idProjeto)
                ->get()
        );
    }

    public function salvarPlanoTeste(PlanoTesteDTO $planoTesteDTO): PlanoTesteDTO
    {
        $planoTeste = new PlanoTeste($planoTesteDTO->toArray());
        $planoTeste->save();
        return PlanoTesteDTO::from($planoTeste);
    }

    public function excluirPlanoTeste(int $idPlanoTeste): bool
    {
        $planoTeste = PlanoTeste::find($idPlanoTeste);
        return $planoTeste->delete();
    }

    public function buscarPlanoTestePorId(int $idPlanoTeste, int $idEquipe): ?PlanoTesteDTO
    {
        $planoTeste = PlanoTeste::select('planos_teste.*')
                        ->where('planos_teste.id',$idPlanoTeste)
                        ->join('projetos.projetos','projetos.id','=','planos_teste.projeto_id')
                        ->join('projetos.aplicacoes','aplicacoes.id','=','projetos.aplicacao_id')
                        ->join('projetos.aplicacoes_equipes','aplicacoes.id','=','aplicacoes_equipes.aplicacao_id')
                        ->where('equipe_id',$idEquipe)
                        ->with('casos_teste')
                        ->first();

        return $planoTeste == null ? null : PlanoTesteDTO::from($planoTeste);
    }

    public function alterarPlanoTeste(PlanoTesteDTO $planoTesteDTO): PlanoTesteDTO
    {
        $planoTeste = PlanoTeste::find($planoTesteDTO->id);
        $planoTeste->titulo = $planoTesteDTO->titulo;
        $planoTeste->descricao = $planoTesteDTO->descricao;
        $planoTeste->update();
        return PlanoTesteDTO::from($planoTeste);
    }

    public function buscarTodosPlanoTeste(int $idEquipe): DataCollection
    {
        return ConsultaPlanoTesteDTO::collection(
            PlanoTeste::select(DB::raw(
                'planos_teste.id,
                       titulo,
                       planos_teste.descricao,
                       user_id, projeto_id,
                       p.nome as nome_projeto,
                       a.nome as nome_aplicacao,
                       planos_teste.created_at,
                       a.id as aplicacao_id,
                       (SELECT MAX(data_execucao)
                        FROM projetos.plano_teste_execucoes pte
                        WHERE planos_teste.id = pte.id) as ultima_execucao'
                )
            )
                ->join('projetos.projetos as p', 'planos_teste.projeto_id','=','p.id')
                ->join('projetos.aplicacoes as a', 'p.aplicacao_id','=','a.id')
                ->get()
        );
    }
}
