<?php

namespace App\Modules\GestaoProjetos\Business;

use App\Modules\GestaoProjetos\Contracts\Business\TarefaBusinessContract;
use App\Modules\GestaoProjetos\Contracts\Repositorys\TarefaRepositoryContract;
use App\Modules\GestaoProjetos\DTOs\TarefaDTO;
use App\Modules\GestaoProjetos\Enums\PermissionEnum;
use App\Modules\GestaoProjetos\Enums\TarefaStatusEnum;
use App\Modules\GestaoProjetos\Repositorys\TarefaRepository;
use App\System\Exceptions\NotFoundException;
use App\System\Impl\BusinessAbstract;
use App\System\Utils\EquipeUtils;
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

    public function updateTarefa(TarefaDTO $tarefaDTO, int $idEquipe): bool
    {
        $this->can(PermissionEnum::ALTERAR_TAREFA->value);
        $tarefa = $this->tarefaRepository->buscarTarefaPorId($tarefaDTO->id, $idEquipe);
        if($tarefa == null){
            throw new NotFoundException();
        }
        return $this->tarefaRepository->updateTarefa($tarefaDTO, $idEquipe);
    }


    public function podeAlterarTarefa(int $idTarefa, int $idEquipe): bool
    {
        $tarefa = $this->tarefaRepository->buscarTarefaPorId($idTarefa, $idEquipe);
        //dd($this->canDo(PermissionEnum::PODE_ALTERAR_TAREFA_CONCLUIDA->value));
        return
            $this->canDo(PermissionEnum::PODE_ALTERAR_TAREFA_CONCLUIDA->value) ||
            ($this->canDo(PermissionEnum::ALTERAR_TAREFA->value) &&
                $tarefa?->status != TarefaStatusEnum::CONCLUIDA->value);
    }

    public function existeTarefaPorTitulo(string $titulo, int $idProjeto, int $idEquipe): bool
    {
        return $this->tarefaRepository->existeTarefaPorTitulo($titulo, $idProjeto, $idEquipe);
    }

    public function buscarTarefaPorId(int $idTarefa, int $idEquipe): ?TarefaDTO
    {
        return $this->tarefaRepository->buscarTarefaPorId($idTarefa, $idEquipe);
    }
}
