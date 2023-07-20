<?php

namespace App\Modules\GestaoProjetos\Business;

use App\Modules\GestaoProjetos\Contracts\Business\ProjetoBusinessContract;
use App\Modules\Projetos\Contracts\Business\AplicacaoBusinessContract;
use App\Modules\GestaoProjetos\Contracts\Repositorys\ProjetoRepositoryContract;
use App\Modules\Projetos\Business\ProjetoBusiness as BaseBusiness;
use Spatie\LaravelData\DataCollection;

class ProjetoBusiness extends BaseBusiness implements ProjetoBusinessContract
{
    public function __construct(
        private readonly ProjetoRepositoryContract $projetoRepository,
        private readonly AplicacaoBusinessContract $aplicacaoBusiness
    )
    {
        parent::__construct($this->projetoRepository, $this->aplicacaoBusiness);
    }
    public function buscarTodosPorEquipe(int $idEquipe): DataCollection
    {
        return $this->projetoRepository->buscarTodosPorEquipe($idEquipe);
    }
}
