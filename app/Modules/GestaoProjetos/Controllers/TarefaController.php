<?php

namespace App\Modules\GestaoProjetos\Controllers;

use App\Modules\GestaoProjetos\Contracts\Business\TarefaBusinessContract;
use App\Modules\GestaoProjetos\DTOs\TarefaDTO;
use App\Modules\GestaoProjetos\Enums\TarefaStatusEnum;
use App\System\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\Finder\Exception\AccessDeniedException;

class TarefaController extends Controller
{
    public function __construct(
        private TarefaBusinessContract $tarefaBusiness
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
}
