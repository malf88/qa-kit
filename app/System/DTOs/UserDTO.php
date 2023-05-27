<?php

namespace App\System\DTOs;

use App\Modules\Projetos\Casts\CastCasosTesteCollection;
use App\System\Casts\CastRoles;
use App\System\Utils\DTO;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Contracts\DataCollectable;

class UserDTO extends DTO
{
    public function __construct(
        public ?int $id,
        public string $name,
        public string $email,
        public ?string $password,
        #[WithCast(CastRoles::class)]
        public ?DataCollectable $roles,
    )
    {
        if($this->password == null)
            $this->password = Hash::make(md5(uniqid('_')));
    }

}
