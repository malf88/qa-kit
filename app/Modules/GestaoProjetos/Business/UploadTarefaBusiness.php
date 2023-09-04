<?php

namespace App\Modules\GestaoProjetos\Business;

use App\Modules\GestaoProjetos\Contracts\Business\ProjetoBusinessContract;
use App\Modules\GestaoProjetos\Contracts\Business\SprintBusinessContract;
use App\Modules\GestaoProjetos\Contracts\Business\TarefaBusinessContract;
use App\Modules\GestaoProjetos\Contracts\Business\UploadTarefaBusinessContract;
use App\Modules\GestaoProjetos\DTOs\ProjetoDTO;
use App\Modules\GestaoProjetos\DTOs\SprintDTO;
use App\Modules\GestaoProjetos\DTOs\TarefaDTO;
use App\Modules\GestaoProjetos\Enums\PermissionEnum;
use App\Modules\GestaoProjetos\Enums\TarefaStatusEnum;
use App\Modules\GestaoProjetos\Libs\PlanilhaEstimativa;
use App\Modules\GestaoProjetos\Requests\UploadTarefaPostRequest;
use App\System\Contracts\Business\UserBusinessContract;
use App\System\Exceptions\NotFoundException;
use App\System\Impl\BusinessAbstract;
use App\System\Traits\TransactionDatabase;
use App\System\Traits\Validation;
use Illuminate\Support\Collection;
use Spatie\LaravelData\DataCollection;

class UploadTarefaBusiness extends BusinessAbstract implements UploadTarefaBusinessContract
{
    use TransactionDatabase, Validation;
    public function __construct(
        private readonly PlanilhaEstimativa $planilhaEstimativa,
        private readonly SprintBusinessContract $sprintBusiness,
        private readonly TarefaBusinessContract $tarefaBusiness,
        private readonly ProjetoBusinessContract $projetoBusiness,
        private readonly UserBusinessContract $userBusiness
    )
    {
    }


    public function processarPlanilha(string $idPlanilha, int $idProjeto, int $idEquipe, UploadTarefaPostRequest $uploadTarefaPostRequest = new UploadTarefaPostRequest()): DataCollection
    {
        $this->can(PermissionEnum::INSERIR_TAREFA->value);
        $this->validation(['url' => $idPlanilha], $uploadTarefaPostRequest);
        $projeto = $this->projetoBusiness->buscarPorIdProjeto($idProjeto, $idEquipe);
        if($projeto == null){
            throw new NotFoundException('Projeto não encontrado');
        }

        $sprints = Collection::empty();
        $this->startTransaction();
        try {
            $this->planilhaEstimativa
                ->processaPlanilha($idPlanilha, $idProjeto)
                ->getSprints()
                ->each(function(SprintDTO $item, $key) use ($sprints, $idEquipe){
                    if(!$this->sprintBusiness->existeSprint($item->nome, $item->projeto_id, $idEquipe)){
                        $sprint = $this->sprintBusiness->salvar($item);
                    }else{
                        $sprint = $this->sprintBusiness->buscarSprintPorNome($item->nome, $item->projeto_id, $idEquipe);
                    }
                    $sprint->tarefas = Collection::empty();
                    $item->tarefas->each(function(TarefaDTO $item, $key) use(&$sprint, $idEquipe) {
                        if($this->tarefaBusiness->existeTarefaPorTitulo($item->titulo, $item->projeto_id, $idEquipe)){
                            return;
                        }
                        $item->sprint = $sprint;
                        $item->sprint_id = $sprint->id;
                        $user = $this->userBusiness->buscarUsuario(['name' => $item->responsavel->name]);

                        if($user->first() == null)
                            throw new NotFoundException('Usuário não encontrado para o item '.$item->titulo);
                        $item->responsavel_id = $user->first()->id;

                        $tarefa = $this->tarefaBusiness->salvar($item);

                        $sprint->tarefas->add($tarefa);
                    });
                    $sprints->add($sprint);
                });
            $this->commit();
        }catch (\Exception $exception){
            $this->rollback();
            throw $exception;
        }
        return SprintDTO::collection($sprints);
    }
}
