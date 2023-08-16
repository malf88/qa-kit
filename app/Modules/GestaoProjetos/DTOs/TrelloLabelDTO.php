<?php

namespace App\Modules\GestaoProjetos\DTOs;

use App\System\Casts\CastCarbonDateTime;
use App\System\Casts\CastCarbonDateTimeTz;
use App\System\Utils\DTO;
use Carbon\Carbon;
use Spatie\LaravelData\Attributes\WithCast;

class TrelloLabelDTO extends DTO
{
    public function __construct(
        public ?string $id,
        public ?string $idBoard,
        public ?string $name,
        public ?string $color,
        public ?string $uses
    )
    {
    }
}
