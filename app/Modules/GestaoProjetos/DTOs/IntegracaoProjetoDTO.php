<?php

namespace App\Modules\GestaoProjetos\DTOs;

use App\System\Utils\DTO;

class IntegracaoProjetoDTO extends DTO
{
    public function __construct(
        public readonly int $projeto_id,
        public readonly string $id_externo,
        public readonly string $retorno
    )
    {
    }
}
