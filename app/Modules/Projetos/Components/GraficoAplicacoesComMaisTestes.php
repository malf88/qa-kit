<?php

namespace App\Modules\Projetos\Components;

use App\Modules\Projetos\Contracts\Business\CoberturaTestesBusinessContract;
use App\System\Utils\EquipeUtils;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class GraficoAplicacoesComMaisTestes extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        private readonly CoberturaTestesBusinessContract $coberturaTestesBusiness
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $coberturaTesteAplicacao = $this->coberturaTestesBusiness->buscarCoberturaTestes(EquipeUtils::equipeUsuarioLogado());

        return view(
            'projetos::Components.grafico-aplicacoes-com-mais-testes',
            compact('coberturaTesteAplicacao')
        );
    }
}
