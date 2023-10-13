<?php

namespace App\Modules\GestaoProjetos\Components;

use App\Modules\GestaoProjetos\Contracts\Business\SprintBusinessContract;
use App\Modules\GestaoProjetos\Contracts\Business\TarefaBusinessContract;
use App\Modules\GestaoProjetos\DTOs\ProjetoDTO;
use App\System\Utils\EquipeUtils;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AlterarTarefa extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public readonly ProjetoDTO $projeto,
        public readonly int $idTarefa,
        private readonly TarefaBusinessContract $tarefaBusiness,
        private readonly SprintBusinessContract $sprintBusiness,
        public string $labelBotaoAbrir = 'Inserir tarefa',
        public string $iconeBotaoAbrir = 'fas fa-tasks',
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {

        $tarefa = $this->tarefaBusiness->buscarTarefaPorId($this->idTarefa, EquipeUtils::equipeUsuarioLogado());
        $sprints = $this->sprintBusiness->listarSprints($this->projeto->id, EquipeUtils::equipeUsuarioLogado());

        return view('gestao-projetos::Components.alterar-tarefa',compact('sprints', 'tarefa'));
    }
}
