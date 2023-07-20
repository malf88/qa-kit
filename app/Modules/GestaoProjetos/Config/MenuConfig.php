<?php

namespace App\Modules\GestaoProjetos\Config;

use App\Modules\GestaoProjetos\Enums\PermissionEnum;
use App\System\Impl\MenuConfigAbstract;
use Illuminate\Support\Facades\Event;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class MenuConfig extends MenuConfigAbstract
{

    static function configureMenuModule()
    {
        Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
            $event->menu->add('Gestão de projetos',[
                'key' => 'gestao-projetos_index',
                'route' => 'gestao-projetos.projetos.index',
                'icon'  => 'fas fa-cogs',
                'text' => 'Gestão de projetos',
                //'can'   => ,
                'active' => ['gestao-projetos/*'],
                'submenu' => [
                    [
                        'text' => 'Gráfico de Gant',
                        'route'  => 'gestao-projetos.projetos.index',
                        'icon'  => 'fas fa-list',
                        'active' => ['gestao-projetos/*'],
                        'can'   => PermissionEnum::VER_GANTT
                    ]
                ]
            ]);
        });
    }
}
