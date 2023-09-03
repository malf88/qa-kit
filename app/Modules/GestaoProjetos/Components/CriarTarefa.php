<?php

namespace App\Modules\GestaoProjetos\Components;

use App\Modules\GestaoProjetos\Contracts\Business\SprintBusinessContract;
use App\Modules\GestaoProjetos\DTOs\ProjetoDTO;
use App\System\Utils\EquipeUtils;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CriarTarefa extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public readonly ProjetoDTO $projeto,
        private readonly SprintBusinessContract $sprintBusiness
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $sprints = $this->sprintBusiness->listarSprints($this->projeto->id, EquipeUtils::equipeUsuarioLogado());
        return view('gestao-projetos::Components.criar-tarefa',compact('sprints'));
    }
}
