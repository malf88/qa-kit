<?php

namespace App\Modules\Projetos\DTOs;

use App\System\Casts\CastEquipes;
use App\System\Utils\DTO;
use Illuminate\Database\Eloquent\Collection;
use Spatie\LaravelData\Contracts\DataCollectable;

class CasoTesteDTO extends DTO
{
    public function __construct(
        public ?int $id,
        public ?string $titulo,
        public ?string $requisito,
        public ?string $cenario,
        public ?string $teste,
        public ?string $resultado_esperado,
        public ?string $status,
        #[WithCast(CastEquipes::class)]
        public DataCollectable|Collection|null $equipes
    )
    {
    }
}
