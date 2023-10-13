<?php

namespace App\Modules\GestaoProjetos\Business;

use App\Modules\GestaoProjetos\Config\TrelloConfig;
use App\Modules\GestaoProjetos\Contracts\Business\ExportBoardTrelloBusinessContract;
use App\Modules\GestaoProjetos\Contracts\Business\ExportCardTrelloBusinessContract;
use App\Modules\GestaoProjetos\Contracts\Business\ProjetoBusinessContract;
use App\Modules\GestaoProjetos\Contracts\Business\TarefaBusinessContract;
use App\Modules\GestaoProjetos\DTOs\ProjetoDTO;
use App\Modules\GestaoProjetos\DTOs\TarefaDTO;
use App\Modules\GestaoProjetos\Enums\PermissionEnum;
use App\Modules\GestaoProjetos\Enums\TarefaStatusEnum;
use App\Modules\GestaoProjetos\Jobs\TrelloExportBoardJobs;
use App\Modules\GestaoProjetos\Jobs\TrelloExportCardJobs;
use App\Modules\GestaoProjetos\Libs\Trello\TrelloBoards;
use App\Modules\GestaoProjetos\Libs\Trello\TrelloLists;
use App\Modules\GestaoProjetos\Services\IntegracaoBoard;
use App\Modules\GestaoProjetos\Services\IntegracaoCard;
use App\Modules\GestaoProjetos\Services\IntegracaoLists;
use App\Modules\GestaoProjetos\Services\IntegracaoUser;
use App\System\Exceptions\NotFoundException;
use App\System\Impl\BusinessAbstract;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class ExportCardTrelloBusiness extends BusinessAbstract implements ExportCardTrelloBusinessContract
{
    public function __construct(
        private readonly TarefaBusinessContract  $tarefaBusiness
    )
    {

    }
    public function enfileirarExportacao(int $idTarefa, int $idEquipe): bool
    {
        $this->can(PermissionEnum::EXPORTAR_PROJETO_TRELLO->value);

        TrelloExportCardJobs::dispatch($idTarefa, $idEquipe);
        return true;

    }
    public function exportar(int $idTarefa, int $idEquipe): bool
    {
        Log::info($idTarefa);
        $tarefa = $this->tarefaBusiness->buscarTarefaPorId($idTarefa, $idEquipe);
        Log::info($tarefa);
        try{
            $projeto = $tarefa->projeto;
            $trelloList = new TrelloLists(new TrelloConfig());
            $lists = $trelloList->get(['id' => $projeto->integracao->id_externo]);
            $listAberta = $lists->where('name','=',TarefaStatusEnum::ABERTA->value)->first();

            $trelloBoardService = new TrelloBoards(new TrelloConfig());
            $board = $trelloBoardService->get(['id' => $projeto->integracao->id_externo]);

            $integracaoCard = app()->make(IntegracaoCard::class);
            $card = $integracaoCard->integrar($tarefa, $board, $listAberta);

        }catch (\Exception $e){
            Log::info($e->getMessage());
            throw $e;
        }


        return true;
    }
}
