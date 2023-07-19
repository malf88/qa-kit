<?php

namespace App\Modules\GestaoProjetos\Controllers;

use App\Modules\Projetos\Contracts\Business\AplicacaoBusinessContract;
use App\Modules\Projetos\Contracts\Business\ProjetoBusinessContract;
use App\Modules\Projetos\DTOs\AplicacaoDTO;
use App\Modules\Projetos\Enums\PermissionEnum;
use App\System\DTOs\EquipeDTO;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnprocessableEntityException;
use App\System\Http\Controllers\Controller;
use App\System\Traits\EquipeTools;
use App\System\Utils\EquipeUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Spatie\LaravelData\DataCollection;


class GantController extends Controller
{
    use EquipeTools;
    public function __construct(
        private readonly ProjetoBusinessContract $projetoBusiness
    )
    {

    }
    public function index()
    {
        $projetos = $this->projetoBusiness->buscarTodosPorAplicacao(1, EquipeUtils::equipeUsuarioLogado());
        return view('gestao-projetos::gant.home', compact('projetos'));
    }

}
