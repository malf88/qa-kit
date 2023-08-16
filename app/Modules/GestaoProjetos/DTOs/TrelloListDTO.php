<?php

namespace App\Modules\GestaoProjetos\DTOs;

use App\System\Casts\CastCarbonDateTime;
use App\System\Casts\CastCarbonDateTimeTz;
use App\System\Utils\DTO;
use Carbon\Carbon;
use Spatie\LaravelData\Attributes\WithCast;

class TrelloListDTO extends DTO
{
    public function __construct(
        public ?string $id,
        public ?string $name,
        public ?bool $closed,
        public ?string $idBoard,
        public ?int $pos,
        public ?bool $subscribed,
        public ?string $softLimit,
        public ?string $status
    )
    {
    }
}
