<?php

namespace App\Modules\GestaoProjetos\DTOs;

use App\Modules\GestaoProjetos\Casts\CastProjeto;
use App\Modules\GestaoProjetos\Casts\CastSprint;
use App\Modules\GestaoProjetos\Casts\CastUser;
use App\System\Casts\CastCarbonDate;
use App\System\Utils\DTO;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\WithCast;

class TarefaDTO extends DTO
{
    public function __construct(
        public ?int $id,
        public ?string $titulo,
        public ?string $descricao,
        public ?string $status,
        public ?int $projeto_id,
        public ?int $responsavel_id,
        public ?int $sprint_id,
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
        public ?SprintDTO $sprint,
        public ?IntegracaoTarefaDTO $integracao

    )
    {
    }
}
