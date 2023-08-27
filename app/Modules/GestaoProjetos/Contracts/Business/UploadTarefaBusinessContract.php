<?php

namespace App\Modules\GestaoProjetos\Contracts\Business;


use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\DataCollection;

interface UploadTarefaBusinessContract
{
    public function processarPlanilha(?UploadedFile $uploadedFile): DataCollection;
}
