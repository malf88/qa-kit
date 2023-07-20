<?php

namespace App\Modules\Projetos\Contracts\Repository;

use App\Modules\Projetos\DTOs\ProjetoDTO;
use App\System\Impl\BaseRepositoryContract;
use Spatie\LaravelData\DataCollection;

interface ProjetoRepositoryContract extends BaseRepositoryContract
{
    public function buscarTodosPorAplicacao(int $aplicacaoId, int $idEquipe):DataCollection;
    public function buscarTodosPorEquipe( int $idEquipe):DataCollection;
    public function buscarPorId(int $idProjeto, int $idEquipe): ?ProjetoDTO;
    public function atualizar(ProjetoDTO $projetoDTO): ProjetoDTO;
    public function excluir(int $id): bool;
    public function inserir(ProjetoDTO $projetoDTO): ProjetoDTO;
}
