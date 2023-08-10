<?php

namespace App\Modules\GestaoProjetos\Casts;

use App\Modules\GestaoProjetos\DTOs\SprintDTO;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\DataProperty;

class CastSprints implements Cast
{
    public function cast(DataProperty $property, mixed $value, array $context): mixed
    {
        return  SprintDTO::collection($value);
    }
}
