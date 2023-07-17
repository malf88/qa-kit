<?php

namespace App\Modules\GestaoProjetos\Providers;

use App\Modules\GestaoProjetos\Config\MenuConfig;
use App\System\Impl\ServiceProviderAbstract;

class GestaoProjetosServiceProvider extends ServiceProviderAbstract
{
    protected string $module_path = 'Modules/GestaoProjetos';
    protected string $prefix = 'gestao-projetos';
    protected string $view_namespace = 'gestao-projetos';
    public $bindings = [];
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        MenuConfig::configureMenuModule();
        //DashboardConfig::addDashboardWidget(new Widget('x-totais-testes'));

        parent::boot();
    }


}
