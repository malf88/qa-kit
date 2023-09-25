<?php

namespace App\Modules\GestaoProjetos\DTOs;

use App\System\Casts\CastCarbonDate;

use App\System\Utils\DTO;

use Illuminate\Support\Carbon;
use Spatie\LaravelData\Attributes\WithCast;

class TarefaSprintDTO extends DTO
{
    public function __construct(
        public ?int $sprint_id,
        public ?string $tarefa_id,
        public ?string $descricao,
        public ?string $status,
        public ?int $projeto_id,
        #[WithCast(CastCarbonDate::class)]
        public ?Carbon $inicio,
        #[WithCast(CastCarbonDate::class)]
        public ?Carbon $termino,
        public ?int $responsavel,
        public ?string $trello_id

    )
    {
    }
}
