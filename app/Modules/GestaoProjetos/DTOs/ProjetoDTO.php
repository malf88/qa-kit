<?php

namespace App\Modules\GestaoProjetos\DTOs;

use App\Modules\Projetos\Casts\CastAplicacao;
use App\Modules\Projetos\DTOs\AplicacaoDTO;
use App\System\Casts\CastCarbonDate;
use App\System\Utils\DTO;
use Carbon\Carbon;
use Spatie\LaravelData\Attributes\WithCast;

class ProjetoDTO extends DTO
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
        public ?float $andamento
    )
    {
    }
}
