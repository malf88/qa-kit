<?php

namespace App\Modules\GestaoProjetos\Services;

use App\Modules\GestaoProjetos\Business\IntegracaoProjetoBusiness;
use App\Modules\GestaoProjetos\Config\TrelloConfig;
use App\Modules\GestaoProjetos\DTOs\IntegracaoProjetoDTO;
use App\Modules\GestaoProjetos\DTOs\IntegracaoUsuarioDTO;
use App\Modules\GestaoProjetos\DTOs\ProjetoDTO;
use App\Modules\GestaoProjetos\DTOs\TrelloBoardDTO;
use App\Modules\GestaoProjetos\Enums\TarefaStatusEnum;
use App\Modules\GestaoProjetos\Libs\Trello\TrelloBoards;
use App\System\Contracts\Business\IntegracaoBusinessContract;
use App\System\DTOs\UserDTO;
use Illuminate\Support\Collection;

class IntegracaoBoard
{
    public function __construct(
        private readonly TrelloBoards $trelloBoardService,
        private readonly IntegracaoBusinessContract $integracaoProjetoBusiness
    )
    {
    }

    public function integrar(ProjetoDTO $projetoDTO):TrelloBoardDTO
    {
        $board = TrelloBoardDTO::from([
            'name' => $projetoDTO->nome,
            'desc' => $projetoDTO->descricao,
            'labelNames' => ['PHP', 'JAVA'],
            'defaultLists' => false
        ]);
        if($projetoDTO->integracao?->id_externo != null){
            $board->id = $projetoDTO->integracao->id_externo;
            return $this->trelloBoardService->update($board);
        }

        $board = $this->trelloBoardService->create($board);
        $integracaoBoardDTO = IntegracaoProjetoDTO::from([
            'projeto_id' => $projetoDTO->id,
            'id_externo' => $board->id,
            'retorno' => json_encode($board)
        ]);
        $this->integracaoProjetoBusiness->registrarIntegracao($integracaoBoardDTO);

        $integracaoList = app()->make(IntegracaoLists::class);
        foreach (array_reverse(TarefaStatusEnum::cases()) as $listsName){
            $integracaoList->integrar($listsName, $board);
        }
        return $board;
    }
}
