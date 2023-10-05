<?php

namespace App\Modules\Projetos\Contracts\Business;

use App\Modules\Projetos\DTOs\DocumentoDTO;
use App\Modules\Projetos\Requests\DocumentosPostRequest;
use Spatie\LaravelData\DataCollection;

interface DocumentoBusinessContract
{
    public function buscarTodosPorProjeto(int $idProjeto, int $idEquipe):DataCollection;
    public function salvar(DocumentoDTO $documentoDTO, int $idEquipe, DocumentosPostRequest $documentosPostRequest = new DocumentosPostRequest()):DocumentoDTO;

    public function excluir(int $idProjeto,  int $idDocumento, int $idEquipe,):bool;
}
