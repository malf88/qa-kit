<?php

namespace App\Modules\GestaoProjetos\Casts;

use App\Modules\GestaoProjetos\DTOs\SprintDTO;
use App\Modules\GestaoProjetos\DTOs\TarefaDTO;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\DataProperty;

class CastTarefas implements Cast
{
    public function cast(DataProperty $property, mixed $value, array $context): mixed
    {
        return  TarefaDTO::collection($value);
    }
}
