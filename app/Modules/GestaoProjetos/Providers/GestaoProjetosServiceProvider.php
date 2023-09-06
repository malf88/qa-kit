<?php

namespace App\Modules\GestaoProjetos\Providers;

use App\Modules\GestaoProjetos\Business\ProjetoBusiness;
use App\Modules\GestaoProjetos\Business\SprintBusiness;
use App\Modules\GestaoProjetos\Business\TarefaBusiness;
use App\Modules\GestaoProjetos\Business\UploadTarefaBusiness;
use App\Modules\GestaoProjetos\Components\AlterarTarefa;
use App\Modules\GestaoProjetos\Components\CriarTarefa;
use App\Modules\GestaoProjetos\Config\MenuConfig;
use App\Modules\GestaoProjetos\Contracts\Business\ProjetoBusinessContract;
use App\Modules\GestaoProjetos\Contracts\Business\SprintBusinessContract;
use App\Modules\GestaoProjetos\Contracts\Business\TarefaBusinessContract;
use App\Modules\GestaoProjetos\Contracts\Business\UploadTarefaBusinessContract;
use App\Modules\GestaoProjetos\Contracts\Repositorys\ProjetoRepositoryContract;
use App\Modules\GestaoProjetos\Contracts\Repositorys\SprintRepositoryContract;
use App\Modules\GestaoProjetos\Contracts\Repositorys\TarefaRepositoryContract;
use App\Modules\GestaoProjetos\Contracts\Repositorys\UploadTarefaRepositoryContract;
use App\Modules\GestaoProjetos\Repositorys\ProjetoRepository;
use App\Modules\GestaoProjetos\Repositorys\SprintRepository;
use App\Modules\GestaoProjetos\Repositorys\TarefaRepository;
use App\Modules\GestaoProjetos\Repositorys\UploadTarefaRepository;
use App\Modules\Projetos\Components\GraficoAplicacoesComMaisTestes;
use App\Modules\Projetos\Providers\ProjetosServiceProvider;
use App\System\Exceptions\NotFoundException;
use App\System\Impl\ServiceProviderAbstract;
use Illuminate\Support\Facades\Blade;

class GestaoProjetosServiceProvider extends ServiceProviderAbstract
{
    protected string $module_path = 'Modules/GestaoProjetos';
    protected string $prefix = 'gestao-projetos';
    protected string $view_namespace = 'gestao-projetos';
    public $bindings = [
        ProjetoRepositoryContract::class => ProjetoRepository::class,
        ProjetoBusinessContract::class => ProjetoBusiness::class,
        TarefaRepositoryContract::class => TarefaRepository::class,
        TarefaBusinessContract::class => TarefaBusiness::class,
        SprintRepositoryContract::class => SprintRepository::class,
        SprintBusinessContract::class => SprintBusiness::class,
        UploadTarefaBusinessContract::class => UploadTarefaBusiness::class,
        UploadTarefaRepositoryContract::class => UploadTarefaRepository::class
    ];
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->moduleExists(ProjetosServiceProvider::class);
        MenuConfig::configureMenuModule();
        Blade::component('criar-tarefa', CriarTarefa::class);
        Blade::component('alterar-tarefa', AlterarTarefa::class);
        //DashboardConfig::addDashboardWidget(new Widget('x-totais-testes'));

        parent::boot();
    }


}
