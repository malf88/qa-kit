<?php

namespace App\Modules\Retrabalhos\Business;


use App\Modules\Retrabalhos\Contracts\Business\UserBusinessContract;
use App\Modules\Retrabalhos\Contracts\Repositorys\UserRepositoryContract;
use App\System\Business\UserBusiness as BaseUserBusiness;
use Illuminate\Support\Facades\App;
use Spatie\LaravelData\DataCollection;
use App\System\Contracts\Repository\UserRepositoryContract as BaseUserRepositoryContract;
class UserBusiness extends BaseUserBusiness implements UserBusinessContract
{
    public function __construct(private readonly UserRepositoryContract $userRepository)
    {
        parent::__construct(App::make(BaseUserRepositoryContract::class));
    }

    public function listaUsuariosByPermissaoDesenvolvedor(): DataCollection
    {
        return $this->userRepository->listaUsuariosByPermissaoDesenvolvedor();
    }
}
