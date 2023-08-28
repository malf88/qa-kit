<?php

namespace App\Modules\GestaoProjetos\Libs;


use App\Modules\GestaoProjetos\DTOs\ProjetoDTO;
use App\Modules\GestaoProjetos\DTOs\SprintDTO;
use App\Modules\GestaoProjetos\DTOs\TarefaDTO;
use App\Modules\GestaoProjetos\Enums\TarefaStatusEnum;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Revolution\Google\Sheets\Facades\Sheets;
use Spatie\LaravelData\DataCollection;

class PlanilhaEstimativa
{
    const COL_ID = 0;
    const COL_PROJECT = 1;
    const COL_SPRINT = 2;
    const COL_PREFIXO = 3;
    const COL_TITULO = 4;
    const COL_INICIO = 8;
    const COL_TERMINO = 9;
    const PLANILHA_ESTIMATIVA = 'estimativa';
    public function __construct(
        private Collection $sprints = new Collection()
    )
    {
    }

    public function processaPlanilha(string $idPlanilha, int $idProjeto):PlanilhaEstimativa
    {
        $values = Sheets::spreadsheet($idPlanilha)
            ->sheet(self::PLANILHA_ESTIMATIVA)
            ->all();
        $prefixo = '';
        foreach ($values as $key => $row){
            if($this->isHeader($row)) continue;

            $this->sprints->add($this->processaSprint($row, $idProjeto));

            if(isset($row[self::COL_PREFIXO]) && $row[self::COL_PREFIXO] != ""){
                $prefixo = $row[self::COL_PREFIXO];
                continue;
            }
            $tarefaDTO = $this->processaTarefa($prefixo, $row, $idProjeto);

            $this->atualizarDatasUltimaSprint($tarefaDTO);

            $this->sprints->last()->tarefas->add($tarefaDTO);
        }
        return $this;

    }
    public function getSprints(): DataCollection
    {
        return SprintDTO::collection($this->sprints);
    }

    private function isHeader($row):bool
    {
        return ($row[self::COL_ID] == 'ID');
    }

    private function processaSprint(array $row, int $idProjeto):SprintDTO
    {
        if(isset($row[self::COL_SPRINT]) && $row[self::COL_SPRINT] != ""){
            return SprintDTO::from([
                'nome' => $row[self::COL_SPRINT],
                'projeto' => ProjetoDTO::from(['id' => $idProjeto]),
                'projeto_id' => $idProjeto,
                'tarefas' => Collection::empty()
            ]);
        }
    }

    private function processaTarefa(string $prefixo, array $row, int $idProjeto):TarefaDTO
    {
        if(isset($row[self::COL_TITULO]) && $row[self::COL_TITULO] != ""){
            return TarefaDTO::from([
                'titulo' => $prefixo.' - '.$row[self::COL_TITULO],
                'projeto_id' => $idProjeto,
                'status' => TarefaStatusEnum::ABERTA->value,
                'inicio_estimado' => Carbon::createFromFormat('d/m/Y', $row[self::COL_INICIO]),
                'termino_estimado' => Carbon::createFromFormat('d/m/Y', $row[self::COL_TERMINO])
            ]);
        }
    }
    private function atualizarDatasUltimaSprint(TarefaDTO $tarefaDTO):void
    {
        if($this->sprints->last()->inicio == null) {
            $this->sprints->last()->inicio = $tarefaDTO->inicio_estimado;
        }
        if($this->sprints->last()->termino == null ||
            $this->sprints->last()->termino->isBefore($tarefaDTO->termino_estimado)){

            $this->sprints->last()->termino = $tarefaDTO->termino_estimado;
        }
    }

}
