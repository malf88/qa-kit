<?php

namespace App\Modules\GestaoProjetos\DTOs;

use App\Modules\GestaoProjetos\Casts\CastSprint;
use App\Modules\Projetos\Casts\CastProjeto;
use App\Modules\Projetos\DTOs\ProjetoDTO;
use App\Modules\Projetos\DTOs\WithCast;
use App\System\Casts\CastCarbonDate;
use App\System\Casts\CastEquipes;
use App\System\Casts\CastUser;
use App\System\Casts\CastUsers;
use App\System\DTOs\UserDTO;
use App\System\Utils\DTO;

use Illuminate\Support\Carbon;
use Spatie\LaravelData\Contracts\DataCollectable;

class TarefaDTO extends DTO
{
    public function __construct(
        public ?int $id,
        public ?string $titulo,
        public ?string $status,
        #[WithCast(CastCarbonDate::class)]
        public ?Carbon $data_arquivamento,
        #[WithCast(CastCarbonDate::class)]
        public ?Carbon $inicio_estimado,
        #[WithCast(CastCarbonDate::class)]
        public ?Carbon $termino_estimado,
        #[WithCast(CastProjeto::class)]
        public ?ProjetoDTO $projeto,
        #[WithCast(CastUser::class)]
        public ?UserDTO $responsavel,
        #[WithCast(CastSprint::class)]
        public ?SprintDTO $sprint

    )
    {
    }
}
