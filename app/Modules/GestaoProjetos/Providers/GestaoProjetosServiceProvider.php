<?php

namespace App\Modules\GestaoProjetos\Providers;

use App\Modules\GestaoProjetos\Business\ExportProjectTrelloBusiness;
use App\Modules\GestaoProjetos\Business\IntegracaoProjetoBusiness;
use App\Modules\GestaoProjetos\Business\IntegracaoTarefaBusiness;
use App\Modules\GestaoProjetos\Business\IntegracaoUsuarioBusiness;
use App\Modules\GestaoProjetos\Business\ProjetoBusiness;
use App\Modules\GestaoProjetos\Business\SprintBusiness;
use App\Modules\GestaoProjetos\Business\TarefaBusiness;
use App\Modules\GestaoProjetos\Business\UploadTarefaBusiness;
use App\Modules\GestaoProjetos\Components\AlterarTarefa;
use App\Modules\GestaoProjetos\Components\CriarTarefa;
use App\Modules\GestaoProjetos\Config\MenuConfig;
use App\Modules\GestaoProjetos\Contracts\Business\ExportProjectTrelloBusinessContract;
use App\Modules\GestaoProjetos\Contracts\Business\ProjetoBusinessContract;
use App\Modules\GestaoProjetos\Contracts\Business\SprintBusinessContract;
use App\Modules\GestaoProjetos\Contracts\Business\TarefaBusinessContract;
use App\Modules\GestaoProjetos\Contracts\Business\UploadTarefaBusinessContract;
use App\Modules\GestaoProjetos\Contracts\Repositorys\ExportProjectTrelloRepositoryContract;
use App\Modules\GestaoProjetos\Contracts\Repositorys\IntegracaoProjetoRepositoryContract;
use App\Modules\GestaoProjetos\Contracts\Repositorys\IntegracaoTarefaRepositoryContract;
use App\Modules\GestaoProjetos\Contracts\Repositorys\IntegracaoUsuarioRepositoryContract;
use App\Modules\GestaoProjetos\Contracts\Repositorys\ProjetoRepositoryContract;
use App\Modules\GestaoProjetos\Contracts\Repositorys\SprintRepositoryContract;
use App\Modules\GestaoProjetos\Contracts\Repositorys\TarefaRepositoryContract;
use App\Modules\GestaoProjetos\Contracts\Repositorys\UploadTarefaRepositoryContract;
use App\Modules\GestaoProjetos\Repositorys\ExportProjectTrelloRepository;
use App\Modules\GestaoProjetos\Repositorys\IntegracaoProjetoRepository;
use App\Modules\GestaoProjetos\Repositorys\IntegracaoTarefaRepository;
use App\Modules\GestaoProjetos\Repositorys\IntegracaoUsuarioRepository;
use App\Modules\GestaoProjetos\Repositorys\ProjetoRepository;
use App\Modules\GestaoProjetos\Repositorys\SprintRepository;
use App\Modules\GestaoProjetos\Repositorys\TarefaRepository;
use App\Modules\GestaoProjetos\Repositorys\UploadTarefaRepository;
use App\Modules\GestaoProjetos\Repositorys\UserRepository;
use App\Modules\GestaoProjetos\Services\IntegracaoBoard;
use App\Modules\GestaoProjetos\Services\IntegracaoCard;
use App\Modules\GestaoProjetos\Services\IntegracaoUser;
use App\Modules\Projetos\Components\GraficoAplicacoesComMaisTestes;
use App\Modules\Projetos\Providers\ProjetosServiceProvider;
use App\System\Contracts\Business\IntegracaoBusinessContract;
use App\System\Contracts\Repository\UserRepositoryContract;
use App\System\Exceptions\NotFoundException;
use App\System\Impl\ServiceProviderAbstract;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\RateLimiter;

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
        UploadTarefaRepositoryContract::class => UploadTarefaRepository::class,
        ExportProjectTrelloRepositoryContract::class => ExportProjectTrelloRepository::class,
        ExportProjectTrelloBusinessContract::class => ExportProjectTrelloBusiness::class,
        IntegracaoUsuarioRepositoryContract::class => IntegracaoUsuarioRepository::class,
        IntegracaoProjetoRepositoryContract::class => IntegracaoProjetoRepository::class,
        IntegracaoTarefaRepositoryContract::class => IntegracaoTarefaRepository::class
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
        $this->app
            ->when(IntegracaoBoard::class)
            ->needs(IntegracaoBusinessContract::class)
            ->give(IntegracaoProjetoBusiness::class);
        $this->app
            ->when(IntegracaoUser::class)
            ->needs(IntegracaoBusinessContract::class)
            ->give(IntegracaoUsuarioBusiness::class);

        $this->app
            ->when(IntegracaoCard::class)
            ->needs(IntegracaoBusinessContract::class)
            ->give(IntegracaoTarefaBusiness::class);
        $this->app
            ->when(IntegracaoUser::class)
            ->needs(UserRepositoryContract::class)
            ->give(UserRepository::class);
        $this->moduleExists(ProjetosServiceProvider::class);
        MenuConfig::configureMenuModule();
        Blade::component('criar-tarefa', CriarTarefa::class);
        Blade::component('alterar-tarefa', AlterarTarefa::class);

        RateLimiter::for('trello', function (object $job) {
            return Limit::perMinutes(10,5);
        });
        //DashboardConfig::addDashboardWidget(new Widget('x-totais-testes'));

        parent::boot();
    }


}
