<?php

namespace App\Modules\GestaoProjetos\Controllers;


use App\Modules\GestaoProjetos\Contracts\Business\ProjetoBusinessContract;
use App\Modules\Projetos\Enums\PermissionEnum;
use App\System\Http\Controllers\Controller;
use App\System\Utils\EquipeUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjetoController extends Controller
{
    public function __construct(
        private readonly ProjetoBusinessContract $projetoBusiness
    )
    {
    }

    public function index()
    {
        Auth::user()->can(PermissionEnum::LISTAR_PROJETO->value);

        $projetos = $this->projetoBusiness->buscarTodosPorEquipe(EquipeUtils::equipeUsuarioLogado());
        return view(
            'gestao-projetos::projetos.home',
            compact('projetos')
        );

    }

}
