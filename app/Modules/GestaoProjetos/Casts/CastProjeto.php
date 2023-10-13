<?php

namespace App\Modules\GestaoProjetos\Casts;

use App\Modules\GestaoProjetos\DTOs\ProjetoDTO;
use App\Modules\Projetos\Casts\CastProjeto as BaseCast;
use Spatie\LaravelData\Support\DataProperty;

class CastProjeto extends BaseCast
{
    public function cast(DataProperty $property, mixed $value, array $context): mixed
    {
        return  ProjetoDTO::from($value);
    }
}
