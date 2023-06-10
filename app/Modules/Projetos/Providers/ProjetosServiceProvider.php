<?php

namespace App\Modules\Projetos\Providers;

use App\Modules\Projetos\Business\AplicacaoBusiness;
use App\Modules\Projetos\Business\CasoTesteBusiness;
use App\Modules\Projetos\Business\CasoTesteExecucaoBusiness;
use App\Modules\Projetos\Business\DocumentoBusiness;
use App\Modules\Projetos\Business\ObservacaoBusiness;
use App\Modules\Projetos\Business\PlanoTesteBusiness;
use App\Modules\Projetos\Business\PlanoTesteExecucaoBusiness;
use App\Modules\Projetos\Business\ProjetoBusiness;
use App\Modules\Projetos\Business\TestesMaisExecutadosBusiness;
use App\Modules\Projetos\Components\CasoTesteDetalhes;
use App\Modules\Projetos\Components\TestesMaisExecutados;
use App\Modules\Projetos\Config\DashboardConfig;
use App\Modules\Projetos\Config\MenuConfig;
use App\Modules\Projetos\Contracts\AplicacaoBusinessContract;
use App\Modules\Projetos\Contracts\AplicacaoRepositoryContract;
use App\Modules\Projetos\Contracts\CasoTesteBusinessContract;
use App\Modules\Projetos\Contracts\CasoTesteExecucaoBusinessContract;
use App\Modules\Projetos\Contracts\CasoTesteExecucaoRepositoryContract;
use App\Modules\Projetos\Contracts\CasoTesteRespositoryContract;
use App\Modules\Projetos\Contracts\DocumentoBusinessContract;
use App\Modules\Projetos\Contracts\DocumentoRepositoryContract;
use App\Modules\Projetos\Contracts\ObservacaoBusinessContract;
use App\Modules\Projetos\Contracts\ObservacaoRepositoryContract;
use App\Modules\Projetos\Contracts\PlanoTesteBusinessContract;
use App\Modules\Projetos\Contracts\PlanoTesteExecucaoBusinessContract;
use App\Modules\Projetos\Contracts\PlanoTesteExecucaoRepositoryContract;
use App\Modules\Projetos\Contracts\PlanoTesteRepositoryContract;
use App\Modules\Projetos\Contracts\ProjetoBusinessContract;
use App\Modules\Projetos\Contracts\ProjetoRepositoryContract;
use App\Modules\Projetos\Contracts\TestesMaisExecutadosBusinessContract;
use App\Modules\Projetos\Contracts\TestesMaisExecutadosRepositoryContract;
use App\Modules\Projetos\Repositorys\AplicacaoRepository;
use App\Modules\Projetos\Repositorys\CasoTesteExecucaoRepository;
use App\Modules\Projetos\Repositorys\CasoTesteRepository;
use App\Modules\Projetos\Repositorys\DocumentoRepository;
use App\Modules\Projetos\Repositorys\ObservacaoRespository;
use App\Modules\Projetos\Repositorys\PlanoTesteExecucaoRepository;
use App\Modules\Projetos\Repositorys\PlanoTesteRepository;
use App\Modules\Projetos\Repositorys\ProjetoRepository;
use App\Modules\Projetos\Repositorys\TestesMaisExecutadosRepository;
use App\System\Component\DeleteModal;
use App\System\Component\Widget;
use App\System\Impl\ServiceProviderAbstract;
use Illuminate\Support\Facades\Blade;

class ProjetosServiceProvider extends ServiceProviderAbstract
{
    protected string $module_path = 'Modules/Projetos';
    protected string $prefix = 'projetos';
    protected string $view_namespace = 'projetos';
    public $bindings = [
        AplicacaoRepositoryContract::class => AplicacaoRepository::class,
        AplicacaoBusinessContract::class => AplicacaoBusiness::class,
        ProjetoRepositoryContract::class => ProjetoRepository::class,
        ProjetoBusinessContract::class => ProjetoBusiness::class,
        ObservacaoBusinessContract::class => ObservacaoBusiness::class,
        ObservacaoRepositoryContract::class => ObservacaoRespository::class,
        DocumentoBusinessContract::class => DocumentoBusiness::class,
        DocumentoRepositoryContract::class => DocumentoRepository::class,
        PlanoTesteBusinessContract::class => PlanoTesteBusiness::class,
        PlanoTesteRepositoryContract::class => PlanoTesteRepository::class,
        CasoTesteBusinessContract::class => CasoTesteBusiness::class,
        CasoTesteRespositoryContract::class => CasoTesteRepository::class,
        PlanoTesteExecucaoBusinessContract::class => PlanoTesteExecucaoBusiness::class,
        PlanoTesteExecucaoRepositoryContract::class => PlanoTesteExecucaoRepository::class,
        CasoTesteExecucaoBusinessContract::class => CasoTesteExecucaoBusiness::class,
        CasoTesteExecucaoRepositoryContract::class => CasoTesteExecucaoRepository::class,
        TestesMaisExecutadosRepositoryContract::class => TestesMaisExecutadosRepository::class,
        TestesMaisExecutadosBusinessContract::class => TestesMaisExecutadosBusiness::class
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
        Blade::component('caso-teste-detalhes', CasoTesteDetalhes::class);
        Blade::component('testes-mais-executados', TestesMaisExecutados::class);
        MenuConfig::configureMenuModule();
        DashboardConfig::addDashboardWidget(new Widget('x-testes-mais-executados'));
        parent::boot();
    }


}
