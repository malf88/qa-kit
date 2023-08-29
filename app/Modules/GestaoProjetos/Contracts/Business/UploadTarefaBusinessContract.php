<?php

namespace App\Modules\GestaoProjetos\Contracts\Business;


use App\Modules\GestaoProjetos\Requests\UploadTarefaPostRequest;
use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\DataCollection;

interface UploadTarefaBusinessContract
{
    public function processarPlanilha(string $idPlanilha, int $idProjeto, int $idEquipe, UploadTarefaPostRequest $uploadTarefaPostRequest = new UploadTarefaPostRequest()): DataCollection;
}
