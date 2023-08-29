<?php

namespace App\Modules\GestaoProjetos\Business;

use App\Modules\GestaoProjetos\Contracts\Business\SprintBusinessContract;
use App\Modules\GestaoProjetos\Contracts\Business\TarefaBusinessContract;
use App\Modules\GestaoProjetos\Contracts\Business\UploadTarefaBusinessContract;
use App\Modules\GestaoProjetos\DTOs\ProjetoDTO;
use App\Modules\GestaoProjetos\DTOs\SprintDTO;
use App\Modules\GestaoProjetos\DTOs\TarefaDTO;
use App\Modules\GestaoProjetos\Enums\TarefaStatusEnum;
use App\Modules\GestaoProjetos\Libs\PlanilhaEstimativa;
use App\System\Impl\BusinessAbstract;
use App\System\Traits\TransactionDatabase;
use Illuminate\Support\Collection;
use Spatie\LaravelData\DataCollection;

class UploadTarefaBusiness extends BusinessAbstract implements UploadTarefaBusinessContract
{
    use TransactionDatabase;
    public function __construct(
        private readonly PlanilhaEstimativa $planilhaEstimativa,
        private readonly SprintBusinessContract $sprintBusiness,
        private readonly TarefaBusinessContract $tarefaBusiness
    )
    {
    }


    public function processarPlanilha(string $idPlanilha, int $idProjeto): DataCollection
    {
        $sprints = Collection::empty();
        ;
        $this->startTransaction();
        try {
            $this->planilhaEstimativa
                ->processaPlanilha($idPlanilha, $idProjeto)
                ->getSprints()
                ->each(function(SprintDTO $item, $key) use ($sprints){
                $sprint = $this->sprintBusiness->salvar($item);
                $sprint->tarefas = Collection::empty();
                $item->tarefas->each(function(TarefaDTO $item, $key) use(&$sprint) {
                    $item->sprint = $sprint;
                    $item->sprint_id = $sprint->id;
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
