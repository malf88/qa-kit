<?php

namespace App\Modules\Projetos\Casts;

use App\Modules\Projetos\DTOs\AplicacaoDTO;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\DataProperty;

class CastAplicacao implements Cast
{
    public function cast(DataProperty $property, mixed $value, array $context): mixed
    {
        return  AplicacaoDTO::from($value);
    }
}
