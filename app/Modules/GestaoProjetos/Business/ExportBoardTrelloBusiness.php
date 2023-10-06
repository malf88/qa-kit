<?php

namespace App\Modules\GestaoProjetos\Business;

use App\Modules\GestaoProjetos\Config\TrelloConfig;
use App\Modules\GestaoProjetos\Contracts\Business\ExportBoardTrelloBusinessContract;
use App\Modules\GestaoProjetos\Contracts\Business\ProjetoBusinessContract;
use App\Modules\GestaoProjetos\DTOs\ProjetoDTO;
use App\Modules\GestaoProjetos\DTOs\TarefaDTO;
use App\Modules\GestaoProjetos\Enums\PermissionEnum;
use App\Modules\GestaoProjetos\Enums\TarefaStatusEnum;
use App\Modules\GestaoProjetos\Jobs\TrelloBoardJobs;
use App\Modules\GestaoProjetos\Libs\Trello\TrelloLists;
use App\Modules\GestaoProjetos\Services\IntegracaoBoard;
use App\Modules\GestaoProjetos\Services\IntegracaoCard;
use App\Modules\GestaoProjetos\Services\IntegracaoLists;
use App\Modules\GestaoProjetos\Services\IntegracaoUser;
use App\System\Exceptions\NotFoundException;
use App\System\Impl\BusinessAbstract;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class ExportBoardTrelloBusiness extends BusinessAbstract implements ExportBoardTrelloBusinessContract
{
    public function __construct(
        private readonly ProjetoBusinessContract $projetoBusiness
    )
    {

    }
    public function enfileirarExportacao(int $idProjeto, int $idEquipe): bool
    {
        $this->can(PermissionEnum::EXPORTAR_PROJETO_TRELLO->value);

        TrelloBoardJobs::dispatch($idProjeto, $idEquipe);
        return true;

    }
    public function exportar(int $idProjeto, int $idEquipe): bool
    {
        $projeto = $this->projetoBusiness->buscarPorIdProjeto($idProjeto, $idEquipe);

        if($projeto == null){
            throw new NotFoundException();
        }

        $serviceBoardIntegracao = app()->make(IntegracaoBoard::class);
        $board = $serviceBoardIntegracao->integrar($projeto);

        $projeto = $this->projetoBusiness->buscarPorIdProjeto($idProjeto, $idEquipe);

        $trelloList = new TrelloLists(new TrelloConfig());
        $lists = $trelloList->get(['id' => $projeto->integracao->id_externo]);
        $listAberta = $lists->where('name','=',TarefaStatusEnum::ABERTA->value)->first();


        $projeto->tarefas->each(function(TarefaDTO $tarefa, $indice) use($board, $listAberta){
            $integracaoUser = app()->make(IntegracaoUser::class);
            $user = $integracaoUser->integrar($tarefa->responsavel, $board);

            $integracaoCard = app()->make(IntegracaoCard::class);
            $card = $integracaoCard->integrar($tarefa, $board, $listAberta);
        });

        return true;
    }
}
