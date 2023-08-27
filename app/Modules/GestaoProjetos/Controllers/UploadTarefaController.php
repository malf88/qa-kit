<?php

namespace App\Modules\GestaoProjetos\Controllers;

use App\Modules\GestaoProjetos\Contracts\Business\ProjetoBusinessContract;
use App\Modules\GestaoProjetos\Contracts\Business\SprintBusinessContract;
use App\Modules\GestaoProjetos\Contracts\Business\TarefaBusinessContract;
use App\Modules\GestaoProjetos\Contracts\Business\UploadTarefaBusinessContract;
use App\Modules\GestaoProjetos\DTOs\TarefaDTO;
use App\Modules\GestaoProjetos\Enums\PermissionEnum;
use App\Modules\GestaoProjetos\Enums\TarefaStatusEnum;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnauthorizedException;
use App\System\Http\Controllers\Controller;
use App\System\Traits\TransactionDatabase;
use App\System\Utils\EquipeUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Finder\Exception\AccessDeniedException;

class UploadTarefaController extends Controller
{
    use TransactionDatabase;
    public function __construct(
        private readonly UploadTarefaBusinessContract $uploadTarefaBusiness
    )
    {
    }
    public function uploadTarefa(Request $request)
    {

        $this->uploadTarefaBusiness->processarPlanilha($request->file('arquivo'));
    }
}
