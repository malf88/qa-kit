<?php

namespace App\Modules\Projetos\Business;

use App\Modules\Projetos\Contracts\Business\CasoTesteExecucaoBusinessContract;
use App\Modules\Projetos\Contracts\Repository\CasoTesteExecucaoRepositoryContract;
use App\Modules\Projetos\DTOs\CasoTesteExecucaoDTO;
use App\Modules\Projetos\Enums\PermissionEnum;
use App\System\Exceptions\ConflictException;
use App\System\Impl\BusinessAbstract;
use Spatie\LaravelData\DataCollection;

class CasoTesteExecucaoBusiness extends BusinessAbstract implements CasoTesteExecucaoBusinessContract
{
    public function __construct(
        private readonly CasoTesteExecucaoRepositoryContract $casoTesteExecucaoRepository
    )
    {
    }


    public function executarCasoTeste(int $idPlanoTesteExecucao, int $idCasoTeste, string $status): bool
    {
        $this->can(PermissionEnum::EXECUTAR_CASO_TESTE->value);
        if($this->casoTesteExecucaoRepository->buscarCasoTesteExecucao($idPlanoTesteExecucao, $idCasoTeste))
            throw new ConflictException();
        return $this->casoTesteExecucaoRepository->executarCasoTeste($idPlanoTesteExecucao, $idCasoTeste, $status);
    }

    public function casoTesteExecutado(int $idPlanoTesteExecucao, int $idCasoTeste): ?CasoTesteExecucaoDTO
    {
        $this->can(PermissionEnum::LISTAR_EXECUCAO_PLANO_TESTE->value);
        return $this->casoTesteExecucaoRepository->buscarCasoTesteExecucao($idPlanoTesteExecucao, $idCasoTeste);

    }

    public function buscarTodosCasosTesteExecucaoPorPlanoTesteExecucao(int $idPlanoTesteExecucao): DataCollection
    {
        $this->can(PermissionEnum::LISTAR_EXECUCAO_PLANO_TESTE->value);
        return  $this->casoTesteExecucaoRepository->buscarTodosCasosTesteExecucaoPorPlanoTesteExecucao($idPlanoTesteExecucao);
    }
}
