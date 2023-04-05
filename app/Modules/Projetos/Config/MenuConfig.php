<?php

namespace App\Modules\Projetos\Config;

use App\System\Impl\MenuConfigAbstract;
use Illuminate\Support\Facades\Event;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class MenuConfig extends MenuConfigAbstract
{

    static function configureMenuModule()
    {
        Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
            // Add some items to the menu...
            $event->menu->add('Projetos');
            $event->menu->add([
                'key' => 'project_index',
                'route' => 'projetos.index',
                'icon'  => 'fas  fa-users',
                'text' => 'Projetos',
            ]);
            $event->menu->add([
                'key' => 'aplicacao_index',
                'route' => 'aplicacoes.index',
                'icon'  => 'fas fa-cogs',
                'text' => 'Aplicações',
            ]);
        });
    }
}
