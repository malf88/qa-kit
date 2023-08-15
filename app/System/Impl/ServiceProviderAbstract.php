<?php

namespace App\System\Impl;

use App\System\Exceptions\InvalidServiceProviderClassException;
use App\System\Exceptions\ModuleNotFoundException;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

abstract class ServiceProviderAbstract extends ServiceProvider
{
    protected string $prefix;
    protected string $view_namespace;
    protected string $module_path;
    public function boot(): void
    {
        app('config')->set($this->prefix, require app_path($this->module_path . DIRECTORY_SEPARATOR . 'Config' . DIRECTORY_SEPARATOR . $this->prefix . '.php'));
        View::addNamespace($this->view_namespace, app_path($this->module_path. '/Views'));
        Route::prefix($this->prefix)
            ->middleware(['web', 'auth'])
            ->group(app_path($this->module_path. '/Routes/route.php'));

    }

    public function moduleExists(string $providerModule):bool
    {

        if (!in_array(self::class,class_parents($providerModule))){
            throw new InvalidServiceProviderClassException();
        }

        if(!class_exists($providerModule)){
            throw new ModuleNotFoundException();
        }
        return true;
    }

}
