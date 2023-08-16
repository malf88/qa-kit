<?php

namespace App\Modules\GestaoProjetos\DTOs;

use App\System\Casts\CastCarbonDateTime;
use App\System\Casts\CastCarbonDateTimeTz;
use App\System\Utils\DTO;
use Carbon\Carbon;
use Spatie\LaravelData\Attributes\WithCast;

class TrelloCardDTO extends DTO
{
    public function __construct(
        public ?string $id,
        public ?array $badges,
        public ?array $checkItemStates,
        public ?bool $closed,
        public ?bool $dueComplete,
        #[WithCast(CastCarbonDateTimeTz::class)]
        public ?Carbon $dateLastActivity,
        public ?string $desc,
        public ?array $descData,
        #[WithCast(CastCarbonDateTimeTz::class)]
        public ?Carbon $due,
        #[WithCast(CastCarbonDateTimeTz::class)]
        public ?Carbon $dueReminder,
        public ?string $email,
        public ?string $idBoard,
        public ?array $idChecklists,
        public ?string $idList,
        public ?array $idMembers,
        public ?array $idMembersVoted,
        public ?int $idShort,
        public ?string $idAttachmentCover,
        public ?array $labels,
        public ?array $idLabels,
        public ?bool $manualCoverAttachment,
        public ?string $name,
        public ?int $pos,
        public ?string $shortLink,
        public ?string $shortUrl,
        #[WithCast(CastCarbonDateTimeTz::class)]
        public ?Carbon $start,
        public ?bool $subscribed,
        public ?string $url,
        public ?array $cover,
        public ?bool $isTemplate,
        public mixed $cardRole
    )
    {
    }
}
