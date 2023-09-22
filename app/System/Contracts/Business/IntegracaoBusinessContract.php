<?php

namespace App\System\Contracts\Business;

use App\System\Utils\DTO;

interface IntegracaoBusinessContract
{
    public function registrarIntegracao(DTO $integracaoDTO):bool;
}
