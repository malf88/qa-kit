<?php

namespace App\Modules\Projetos\Repositorys;

use App\Modules\Projetos\Contracts\Repository\ProjetoRepositoryContract;
use App\Modules\Projetos\DTOs\ProjetoDTO;
use App\Modules\Projetos\Models\Aplicacao;
use App\Modules\Projetos\Models\Projeto;
use App\System\Impl\BaseRepository;
use Spatie\LaravelData\DataCollection;

class ProjetoRepository extends BaseRepository  implements ProjetoRepositoryContract
{

    public function buscarTodosPorAplicacao(int $aplicacaoId, int $idEquipe): DataCollection
    {
        return ProjetoDTO::collection(
            Aplicacao::find($aplicacaoId)
                ->projetos()
                ->select('projetos.*')
                ->join('projetos.aplicacoes','aplicacoes.id','=','projetos.aplicacao_id')
                ->join('projetos.aplicacoes_equipes','aplicacoes.id','=','aplicacoes_equipes.aplicacao_id')
                ->where('equipe_id',$idEquipe)
                ->get()
        );
    }

    public function buscarPorId(int $idProjeto, int $idEquipe): ?ProjetoDTO
    {
        $projeto = Projeto::select('projetos.*')
                            ->join('projetos.aplicacoes','aplicacoes.id','=','projetos.aplicacao_id')
                            ->join('projetos.aplicacoes_equipes','aplicacoes.id','=','aplicacoes_equipes.aplicacao_id')
                            ->where('equipe_id',$idEquipe)
                            ->where('projetos.id', $idProjeto)
                            ->first();

        return $projeto != null ? ProjetoDTO::from($projeto) : null;
    }

    public function atualizar(ProjetoDTO $projetoDTO): ProjetoDTO
    {
        $projeto = Projeto::find($projetoDTO->id);
        $projeto->fill($projetoDTO->toArray());

        $projeto->update();
        return ProjetoDTO::from($projeto);

    }

    public function excluir(int $id): bool
    {
        $projeto = Projeto::find($id);
        return $projeto->delete();
    }

    public function inserir(ProjetoDTO $projetoDTO): ProjetoDTO
    {
        $projeto = new Projeto($projetoDTO->toArray());
        $projeto->save();
        return ProjetoDTO::from($projeto);
    }

    public function buscarTodosPorEquipe(int $idEquipe): DataCollection
    {
        return ProjetoDTO::collection(
            Projeto::select('projetos.*')
                ->join('projetos.aplicacoes','aplicacoes.id','=','projetos.aplicacao_id')
                ->join('projetos.aplicacoes_equipes','aplicacoes.id','=','aplicacoes_equipes.aplicacao_id')
                ->where('equipe_id',$idEquipe)
                ->get()
        );
    }
}
