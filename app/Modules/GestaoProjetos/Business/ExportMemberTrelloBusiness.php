<?php

namespace App\Modules\GestaoProjetos\Business;

use App\Modules\GestaoProjetos\Config\TrelloConfig;
use App\Modules\GestaoProjetos\Contracts\Business\ExportBoardTrelloBusinessContract;
use App\Modules\GestaoProjetos\Contracts\Business\ExportMemberTrelloBusinessContract;
use App\Modules\GestaoProjetos\Contracts\Business\ProjetoBusinessContract;
use App\Modules\GestaoProjetos\DTOs\ProjetoDTO;
use App\Modules\GestaoProjetos\DTOs\TarefaDTO;
use App\Modules\GestaoProjetos\Enums\PermissionEnum;
use App\Modules\GestaoProjetos\Enums\TarefaStatusEnum;
use App\Modules\GestaoProjetos\Jobs\TrelloExportBoardJobs;
use App\Modules\GestaoProjetos\Jobs\TrelloExportMemberJobs;
use App\Modules\GestaoProjetos\Libs\Trello\TrelloBoards;
use App\Modules\GestaoProjetos\Libs\Trello\TrelloLists;
use App\Modules\GestaoProjetos\Repositorys\UserRepository;
use App\Modules\GestaoProjetos\Services\IntegracaoBoard;
use App\Modules\GestaoProjetos\Services\IntegracaoCard;
use App\Modules\GestaoProjetos\Services\IntegracaoLists;
use App\Modules\GestaoProjetos\Services\IntegracaoUser;
use App\System\Exceptions\NotFoundException;
use App\System\Impl\BusinessAbstract;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class ExportMemberTrelloBusiness extends BusinessAbstract implements ExportMemberTrelloBusinessContract
{
    public function __construct(
        private readonly ProjetoBusinessContract $projetoBusiness,
        private readonly UserRepository $userRepository
    )
    {

    }
    public function enfileirarExportacao(int $idUsuario, int $idProjeto, int $idEquipe): bool
    {
        $this->can(PermissionEnum::EXPORTAR_PROJETO_TRELLO->value);

        TrelloExportMemberJobs::dispatch($idUsuario, $idProjeto, $idEquipe);
        return true;

    }
    public function exportar(int $idUsuario, int $idProjeto, int $idEquipe): bool
    {
        $projeto = $this->projetoBusiness->buscarPorIdProjeto($idProjeto, $idEquipe);
        $boardService = new TrelloBoards(new TrelloConfig());
        $board = $boardService->get(['id' => $projeto->integracao->id_externo]);
        $usuario = $this->userRepository->buscarPorId($idUsuario);
        $integracaoUser = app()->make(IntegracaoUser::class);
        $user = $integracaoUser->integrar($usuario, $board);
        return true;
    }
}
