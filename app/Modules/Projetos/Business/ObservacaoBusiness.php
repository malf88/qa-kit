<?php

namespace App\Modules\Projetos\Business;

use App\Modules\Projetos\Contracts\Business\ObservacaoBusinessContract;
use App\Modules\Projetos\Contracts\Business\ProjetoBusinessContract;
use App\Modules\Projetos\Contracts\Repository\ObservacaoRepositoryContract;
use App\Modules\Projetos\DTOs\ObservacaoDTO;
use App\Modules\Projetos\Requests\ObservacoesPostRequest;
use App\System\DTOs\UserDTO;
use App\Modules\Projetos\Enums\PermissionEnum;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnprocessableEntityException;
use App\System\Impl\BusinessAbstract;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\LaravelData\DataCollection;

class ObservacaoBusiness extends BusinessAbstract implements ObservacaoBusinessContract
{
    public function __construct(
        private readonly ObservacaoRepositoryContract $observacaoRepository,
        private readonly ProjetoBusinessContract $projetoBusiness
    )
    {
    }

    public function buscarPorProjeto(int $projetoId): DataCollection
    {
        return $this->observacaoRepository->buscarPorProjeto($projetoId);
    }

    public function salvar(ObservacaoDTO $observacaoDTO, int $idEquipe, ObservacoesPostRequest $observacoesPostRequest = new ObservacoesPostRequest()): ObservacaoDTO
    {
        $this->can(PermissionEnum::ADICIONAR_COMENTARIO_PROJETO->value);
        $projeto = $this->projetoBusiness->buscarPorIdProjeto($observacaoDTO->projeto_id, $idEquipe);
        if(!$this->projetoBusiness->projetoExists($projeto->aplicacao_id, $projeto->id, $idEquipe)){
            throw new NotFoundException();
        }

        $observacaoDTO->user = UserDTO::from(Auth::user());
        $observacaoDTO->user_id = Auth::user()->id;
        $validator = Validator::make($observacaoDTO->toArray(), $observacoesPostRequest->rules());

        if ($validator->fails()) {
            throw new UnprocessableEntityException($validator);
        }

        return $this->observacaoRepository->salvar($observacaoDTO);
    }
}
