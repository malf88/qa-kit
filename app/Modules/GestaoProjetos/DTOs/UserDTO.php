<?php

namespace App\Modules\GestaoProjetos\DTOs;
use App\System\Casts\CastEquipes;
use App\System\Casts\CastRoles;
use App\System\DTOs\UserDTO as BaseDTO;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Contracts\DataCollectable;

class UserDTO extends BaseDTO
{
    public function __construct(
        ?int $id,
        ?string $name,
        ?string $email,
        ?string $password,
        ?string $password_confirmation,
        #[WithCast(CastRoles::class)]
        ?DataCollectable $roles,
        #[WithCast(CastEquipes::class)]
        ?DataCollectable $equipes,
        public ?IntegracaoUsuarioDTO $integracao
    )
    {
        parent::__construct($id, $name, $email, $password, $password_confirmation, $roles, $equipes);
    }

}
