<?php

namespace App\Modules\GestaoProjetos\DTOs;

use App\System\Casts\CastCarbonDateTime;
use App\System\Casts\CastCarbonDateTimeTz;
use App\System\Utils\DTO;
use Carbon\Carbon;
use Spatie\LaravelData\Attributes\WithCast;

class TrelloMemberDTO extends DTO
{
    public function __construct(
        public ?string $id,
        public ?string $fullName,
        public ?string $username,
        public ?string $email,
        public ?string $type
    )
    {
    }
}
