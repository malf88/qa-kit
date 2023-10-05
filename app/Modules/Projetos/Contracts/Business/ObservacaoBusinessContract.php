<?php

namespace App\Modules\Projetos\Contracts\Business;

use App\Modules\Projetos\DTOs\ObservacaoDTO;
use App\Modules\Projetos\Requests\ObservacoesPostRequest;
use Spatie\LaravelData\DataCollection;

interface ObservacaoBusinessContract
{
    public function buscarPorProjeto(int $projetoId): DataCollection;
    public function salvar(ObservacaoDTO $observacaoDTO, int $idEquipe, ObservacoesPostRequest $observacoesPostRequest = new ObservacoesPostRequest()): ObservacaoDTO;
}
