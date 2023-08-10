<?php

namespace App\Modules\GestaoProjetos\DTOs;

use App\Modules\GestaoProjetos\Casts\CastSprints;
use App\Modules\GestaoProjetos\Casts\CastTarefas;
use App\Modules\Projetos\Casts\CastAplicacao;
use App\Modules\Projetos\DTOs\AplicacaoDTO;
use App\Modules\Projetos\DTOs\ProjetoDTO as ProjetoBaseDTO;
use App\System\Casts\CastCarbonDate;
use App\System\Utils\DTO;
use Carbon\Carbon;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Contracts\DataCollectable;

class ProjetoDTO extends ProjetoBaseDTO
{
    public function __construct(
        public ?int $id,
        public ?string $nome,
        public ?string $descricao,
        #[WithCast(CastCarbonDate::class)]
        public ?Carbon $inicio,
        #[WithCast(CastCarbonDate::class)]
        public ?Carbon $termino,
        public ?int $aplicacao_id,
        #[WithCast(CastAplicacao::class)]
        public ?AplicacaoDTO $aplicacao,
        public ?float $andamento,
        #[WithCast(CastSprints::class)]
        public ?DataCollectable $sprints,
        #[WithCast(CastTarefas::class)]
        public ?DataCollectable $tarefas,
    )
    {
    }
}
