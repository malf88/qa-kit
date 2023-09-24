<?php

namespace App\Modules\GestaoProjetos\Services;

use App\Modules\GestaoProjetos\Business\IntegracaoProjetoBusiness;
use App\Modules\GestaoProjetos\DTOs\IntegracaoProjetoDTO;
use App\Modules\GestaoProjetos\DTOs\IntegracaoUsuarioDTO;
use App\Modules\GestaoProjetos\DTOs\ProjetoDTO;
use App\Modules\GestaoProjetos\DTOs\TrelloBoardDTO;
use App\Modules\GestaoProjetos\Libs\Trello\TrelloBoards;
use App\System\Contracts\Business\IntegracaoBusinessContract;
use App\System\DTOs\UserDTO;

class IntegracaoBoard
{
    public function __construct(
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

        $trelloBoardService = new TrelloBoards(
            'ATTAe8d2bec2b9b0a5874bb88ccda0d6d0c5d187feea9d6e15c6a7ef643276d48ba8D8DEF6DB',
            '4af9dd9f228be32b068c307a01ee268f'
        );
        $board = $trelloBoardService->create($board);
        $integracaoBoardDTO = IntegracaoProjetoDTO::from([
            'projeto_id' => $projetoDTO->id,
            'id_externo' => $board->id,
            'retorno' => json_encode($board)
        ]);
        $this->integracaoProjetoBusiness->registrarIntegracao($integracaoBoardDTO);
        return $board;
    }
}
