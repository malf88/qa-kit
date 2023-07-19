<?php

namespace App\Modules\GestaoProjetos\DTOs;

use App\Modules\GestaoProjetos\Casts\CastTarefa;
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

class AuditoriaTarefaDTO extends DTO
{
    public function __construct(
        public ?int $id,
        public ?string $tipo_registro,
        public ?string $descricao,
        #[WithCast(CastTarefa::class)]
        public ?TarefaDTO $tarefa,
        #[WithCast(CastUser::class)]
        public ?UserDTO $user

    )
    {
    }
}
