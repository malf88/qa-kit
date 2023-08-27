<?php

namespace App\System\Providers;

use App\System\Business\EquipeBusiness;
use App\System\Business\UserBusiness;
use App\System\Component\ComboEquipes;
use App\System\Component\DeleteModal;
use App\System\Component\GenericModal;
use App\System\Component\UploadModal;
use App\System\Config\MenuConfig;
use App\System\Contracts\Business\EquipeBusinessContract;
use App\System\Contracts\Business\UserBusinessContract;
use App\System\Contracts\Repository\EquipeRepositoryContract;
use App\System\Contracts\Repository\UserRepositoryContract;
use App\System\Repositorys\EquipeRepository;
use App\System\Repositorys\UserRepository;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $bindings = [
        UserBusinessContract::class => UserBusiness::class,
        UserRepositoryContract::class => UserRepository::class,
        EquipeBusinessContract::class => EquipeBusiness::class,
        EquipeRepositoryContract::class => EquipeRepository::class
    ];
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::component('delete-modal', DeleteModal::class);
        Blade::component('combo-equipes', ComboEquipes::class);
        Blade::component('upload-modal', UploadModal::class);
        Blade::component('generic-modal', GenericModal::class);
        MenuConfig::configureMenuModule();
        $this->addDirectoryMigration();

        if ($this->app->environment('production')) {
            $this->app['request']->server->set('HTTPS','on');

        }

    }

    private function addDirectoryMigration(){
        $mainPath = database_path('migrations');
        $directories = glob(app_path('Modules') . '/*/Migrations' , GLOB_ONLYDIR);
        $paths = array_merge([$mainPath], $directories);

        $this->loadMigrationsFrom($paths);
    }
}
