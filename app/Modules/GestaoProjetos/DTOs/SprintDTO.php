<?php

namespace App\Modules\GestaoProjetos\DTOs;

use App\Modules\Projetos\Casts\CastProjeto;
use App\Modules\Projetos\DTOs\ProjetoDTO;
use App\Modules\Projetos\DTOs\WithCast;
use App\System\Casts\CastCarbonDate;
use App\System\Casts\CastEquipes;
use App\System\Utils\DTO;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Contracts\DataCollectable;

class SprintDTO extends DTO
{

    public function __construct(
        public ?int $id,
        public ?string $nome,
        public ?int $projeto_id,
        #[WithCast(CastCarbonDate::class)]
        public ?Carbon $inicio,
        #[WithCast(CastCarbonDate::class)]
        public ?Carbon $termino,
        #[WithCast(CastProjeto::class)]
        public ?ProjetoDTO $projeto,
        public ?Collection $tarefas

    )
    {
    }
}
