<?php

namespace App\System\Casts;

use Carbon\Carbon;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Casts\Castable;
use Spatie\LaravelData\Support\DataProperty;

class CastCarbonDateTimeTz implements Cast
{
    public function cast(DataProperty $property, mixed $value, array $context): mixed
    {
        return  Carbon::createFromFormat('Y-m-d\TH:i:s.uP', $value);
    }
}
