<?php

namespace App\Modules\GestaoProjetos\Business;

use App\Modules\GestaoProjetos\Contracts\Business\TarefaBusinessContract;
use App\Modules\GestaoProjetos\Contracts\Repositorys\TarefaRepositoryContract;
use App\Modules\GestaoProjetos\DTOs\TarefaDTO;
use App\Modules\GestaoProjetos\Enums\PermissionEnum;
use App\Modules\GestaoProjetos\Repositorys\TarefaRepository;
use App\System\Impl\BusinessAbstract;
use Spatie\LaravelData\DataCollection;
use Symfony\Component\Finder\Exception\AccessDeniedException;

class TarefaBusiness extends BusinessAbstract implements TarefaBusinessContract
{

    public function __construct(
        private TarefaRepositoryContract $tarefaRepository
    )
    {
    }

    public function salvar(TarefaDTO $tarefaDTO): TarefaDTO
    {
        $this->can(PermissionEnum::INSERIR_TAREFA->value);
        return $this->tarefaRepository->salvar($tarefaDTO);
    }

    public function listarTarefasComSprint(int $idProjeto, int $idEquipe): DataCollection
    {
        $this->can(PermissionEnum::LISTAR_TAREFA->value);
        return $this->tarefaRepository->listarTarefasComSprint($idProjeto, $idEquipe);
    }
}
