<?php

namespace App\System\Casts;

use App\Modules\GestaoProjetos\DTOs\SprintDTO;
use App\Modules\GestaoProjetos\DTOs\TarefaDTO;
use App\System\DTOs\UserDTO;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\DataProperty;

class CastUser implements Cast
{
    public function cast(DataProperty $property, mixed $value, array $context): mixed
    {
        return  UserDTO::from($value);
    }
}
