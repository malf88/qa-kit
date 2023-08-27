<?php

namespace App\Modules\GestaoProjetos\Controllers;

use App\Modules\GestaoProjetos\Contracts\Business\ProjetoBusinessContract;
use App\Modules\GestaoProjetos\Contracts\Business\SprintBusinessContract;
use App\Modules\GestaoProjetos\Contracts\Business\TarefaBusinessContract;
use App\Modules\GestaoProjetos\DTOs\TarefaDTO;
use App\Modules\GestaoProjetos\Enums\PermissionEnum;
use App\Modules\GestaoProjetos\Enums\TarefaStatusEnum;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnauthorizedException;
use App\System\Http\Controllers\Controller;
use App\System\Traits\TransactionDatabase;
use App\System\Utils\EquipeUtils;
use Google\Client;
use Google_Service_Sheets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Revolution\Google\Sheets\Facades\Sheets;
use Symfony\Component\Finder\Exception\AccessDeniedException;

class TarefaController extends Controller
{
    use TransactionDatabase;
    public function __construct(
        private readonly ProjetoBusinessContract $projetoBusiness,
        private readonly TarefaBusinessContract $tarefaBusiness,
        private readonly SprintBusinessContract $sprintBusiness
    )
    {
    }
    public function salvar(Request $request)
    {
        try{
            $tarefaDto = TarefaDTO::from($request->all());
            $tarefaDto->status = TarefaStatusEnum::ABERTA->value;
            $this->tarefaBusiness->salvar($tarefaDto);
            return redirect(route('gestao-projetos.projetos.index'))
                ->with([Controller::MESSAGE_KEY_SUCCESS => ['Tarefa inserida com sucesso!']]);
        }catch (AccessDeniedException $e){
            return redirect(route('gestao-projetos.projetos.index'))
                ->with([Controller::MESSAGE_KEY_ERROR => ['Acesso negado']]);

        }

    }
    public function tarefas(Request $request, int $idProjeto)
    {

//        $values = Sheets::spreadsheet('1dI-cQkM9BTG-HWkMsGptSzWUa9Kh8ZG6slT7b0Adu3U')->sheet('estimativa')->all();
//        dd($values);
        Auth::user()->can(PermissionEnum::LISTAR_TAREFA->value);
        $heads = [
            ['label' => 'Id', 'width' => 10],
            'Sprint',
            'Descrição',
            'Início',
            'Término',
            'Status'
        ];

        $config = [
            ...config('adminlte.datatable_config'),
            'ordering' => false,
        ];
        $projetoController = App::make(TarefaController::class);
        $tarefas = $this->tarefaBusiness->listarTarefasComSprint($idProjeto, EquipeUtils::equipeUsuarioLogado());
        $projeto = $this->projetoBusiness->buscarPorIdProjeto($idProjeto, EquipeUtils::equipeUsuarioLogado());
        $sprints = $this->sprintBusiness->listarSprints($idProjeto, EquipeUtils::equipeUsuarioLogado());
        return view(
            'gestao-projetos::projetos.tarefas',
            compact('tarefas', 'projeto', 'sprints', 'heads', 'config', 'projetoController')
        );

    }
    public function updateTarefa(Request $request, int $idProjeto){
        try {
            $this->startTransaction();
            foreach ($request->get('sprint') as $tarefa => $sprint){
                $this->tarefaBusiness->updateSprint($tarefa, $sprint, EquipeUtils::equipeUsuarioLogado());
            }
            $this->commit();
            return redirect(route('gestao-projetos.projetos.tarefas.index', $idProjeto))
                ->with([Controller::MESSAGE_KEY_SUCCESS => ['Tarefas atualizadas com sucesso']]);
        }catch (UnauthorizedException $e){
            $this->rollback();
            throw $e;
        }catch (NotFoundException $e){
            $this->rollback();
            return redirect(route('gestao-projetos.projetos.tarefas.index', $idProjeto))
                ->with([Controller::MESSAGE_KEY_SUCCESS => ['Tarefa não encontrada.']]);
        }
    }

    public function podeEditarTarefa(int $idTarefa):bool
    {
        return $this->tarefaBusiness->podeAlterarTarefa($idTarefa, EquipeUtils::equipeUsuarioLogado());
    }
}
