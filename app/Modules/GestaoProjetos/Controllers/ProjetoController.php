<?php

namespace App\Modules\GestaoProjetos\Controllers;


use App\Modules\GestaoProjetos\Contracts\Business\ProjetoBusinessContract;
use App\Modules\GestaoProjetos\Contracts\Business\TarefaBusinessContract;
use App\Modules\GestaoProjetos\Enums\PermissionEnum;
use App\Modules\Projetos\Enums\PermissionEnum as ProjetoPermisssionEnum;
use App\System\Http\Controllers\Controller;
use App\System\Utils\EquipeUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjetoController extends Controller
{
    public function __construct(
        private readonly ProjetoBusinessContract $projetoBusiness,
        private readonly TarefaBusinessContract $tarefaBusiness
    )
    {
    }

    public function index()
    {
        Auth::user()->can(ProjetoPermisssionEnum::LISTAR_PROJETO->value);

        $projetos = $this->projetoBusiness->buscarTodosPorEquipe(EquipeUtils::equipeUsuarioLogado());

        return view(
            'gestao-projetos::projetos.home',
            compact('projetos')
        );

    }

    public function tarefas(int $idProjeto)
    {
        Auth::user()->can(PermissionEnum::LISTAR_TAREFA->value);
        $heads = [
            ['label' => 'Id', 'width' => 10],
            'Descrição',
            'Início',
            'Término',
            'Status'
        ];

        $config = [
            ...config('adminlte.datatable_config'),
            'columns' => [null, null, null, null],
        ];
        $tarefas = $this->tarefaBusiness->listarTarefasComSprint($idProjeto, EquipeUtils::equipeUsuarioLogado());

        return view(
            'gestao-projetos::projetos.tarefas',
            compact('tarefas', 'heads', 'config')
        );

    }

}
