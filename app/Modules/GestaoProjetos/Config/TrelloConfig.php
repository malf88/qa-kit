<?php

namespace App\Modules\GestaoProjetos\Config;

class TrelloConfig
{
    public function getToken():string
    {
        return config('gestao-projetos.trello_token');
    }

    public function getKey():string
    {
        return config('gestao-projetos.trello_key');
    }
}
