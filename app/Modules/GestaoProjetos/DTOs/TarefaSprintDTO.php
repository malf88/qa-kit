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

    )
    {
    }
}
