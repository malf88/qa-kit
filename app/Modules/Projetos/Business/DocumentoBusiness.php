<?php

namespace App\Modules\Projetos\Business;

use App\Modules\Projetos\Contracts\Business\DocumentoBusinessContract;
use App\Modules\Projetos\Contracts\Business\ProjetoBusinessContract;
use App\Modules\Projetos\Contracts\Repository\DocumentoRepositoryContract;
use App\Modules\Projetos\DTOs\DocumentoDTO;
use App\Modules\Projetos\Requests\DocumentosPostRequest;
use App\Modules\Projetos\Enums\PermissionEnum;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnprocessableEntityException;
use App\System\Impl\BusinessAbstract;
use App\System\Utils\EquipeUtils;
use Illuminate\Support\Facades\Validator;
use Spatie\LaravelData\DataCollection;

class DocumentoBusiness extends BusinessAbstract implements DocumentoBusinessContract
{
    public function __construct(
        private readonly DocumentoRepositoryContract $documentoRepository,
        private readonly ProjetoBusinessContract $projetoBusiness
    )
    {
    }

    public function buscarTodosPorProjeto(int $idProjeto, int $idEquipe): DataCollection
    {
        $projeto = $this->projetoBusiness->buscarPorIdProjeto($idProjeto, $idEquipe);
        if($projeto == null)
            throw new NotFoundException();

        return $this->documentoRepository->buscarTodosPorProjeto($idProjeto);
    }

    public function salvar(DocumentoDTO $documentoDTO, int $idEquipe, DocumentosPostRequest $documentosPostRequest = new DocumentosPostRequest()): DocumentoDTO
    {
        $this->can(PermissionEnum::ADICIONAR_DOCUMENTO_PROJETO->value);
        $projeto = $this->projetoBusiness->buscarPorIdProjeto($documentoDTO->projeto_id, $idEquipe);
        if($projeto == null)
            throw new NotFoundException();

        $validator = Validator::make($documentoDTO->toArray(), $documentosPostRequest->rules());

        if ($validator->fails()) {
            throw new UnprocessableEntityException($validator);
        }
        return $this->documentoRepository->salvar($documentoDTO);

    }

    public function excluir(int $idProjeto, int $idDocumento, int $idEquipe): bool
    {
        $this->can(PermissionEnum::REMOVER_DOCUMENTO_PROJETO->value);
        $projeto = $this->projetoBusiness->buscarPorIdProjeto($idProjeto, $idEquipe);
        if($projeto == null)
            throw new NotFoundException();

        return $this->documentoRepository->excluir($idDocumento);

    }
}
