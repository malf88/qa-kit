<?php

namespace App\Modules\GestaoProjetos\DTOs;

use App\System\Utils\DTO;

class TrelloBoardDTO extends DTO
{
    public function __construct(
        public ?string $id,
        public string $name,
        public ?string $desc,
        public ?string $descData,
        public ?bool $closed,
        public ?string $idOrganization,
        public ?string $idEnterprise,
        public ?bool $pinned,
        public ?string $url,
        public ?string $shortUrl,
        public ?array $prefs,
        public ?array $labelNames,
        public ?bool $defaultLabels,
        public ?bool $defaultLists,

    )
    {
    }
}
