<?php

namespace App\Modules\GestaoProjetos\Business;

use App\Modules\GestaoProjetos\Contracts\Business\UploadTarefaBusinessContract;
use App\Modules\GestaoProjetos\DTOs\ProjetoDTO;
use App\Modules\GestaoProjetos\Models\TarefaExcelModel;
use App\Modules\Projetos\Contracts\Business\AplicacaoBusinessContract;
use App\Modules\GestaoProjetos\Contracts\Repositorys\ProjetoRepositoryContract;
use App\Modules\Projetos\Models\CasoTesteExcelModel;
use App\System\Impl\BusinessAbstract;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\LaravelData\DataCollection;

class UploadTarefaBusiness extends BusinessAbstract implements UploadTarefaBusinessContract
{
    public function __construct(
    )
    {
    }

    public function processarPlanilha(?UploadedFile $uploadedFile): DataCollection
    {
        Storage::put('tmp/',$uploadedFile);

        $tarefas = Excel::toCollection(new TarefaExcelModel(), Storage::path('tmp/'.$uploadedFile->hashName()));
        dd($tarefas);

    }
}
