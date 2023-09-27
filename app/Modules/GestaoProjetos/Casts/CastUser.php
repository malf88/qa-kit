<?php

namespace App\Modules\GestaoProjetos\Casts;

use App\Modules\GestaoProjetos\DTOs\UserDTO;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\DataProperty;

class CastUser implements Cast
{
    public function cast(DataProperty $property, mixed $value, array $context): mixed
    {
        return  UserDTO::from($value);
    }
}
