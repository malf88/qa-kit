<?php

namespace App\Modules\GestaoProjetos\Controllers;

use App\Modules\GestaoProjetos\Contracts\Business\ProjetoBusinessContract;
use App\System\Http\Controllers\Controller;

class KanbanController extends Controller
{
    public function __construct(
        private readonly ProjetoBusinessContract $projetoBusiness
    )
    {
    }
    public function index(int $idProjeto){
        dd($idProjeto);
    }
}
