<?php

namespace App\Modules\GestaoProjetos\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CriarTarefa extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('gestao-projetos::Components.criar-tarefa');
    }
}
