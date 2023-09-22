<?php

namespace App\Modules\GestaoProjetos\DTOs;

use App\System\Utils\DTO;

class IntegracaoUsuarioDTO extends DTO
{
    public function __construct(
        public readonly int $user_id,
        public readonly string $id_externo,
        public readonly string $retorno
    )
    {
    }

}
