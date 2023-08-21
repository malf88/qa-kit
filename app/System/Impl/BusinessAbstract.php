<?php

namespace App\System\Impl;

use App\System\Exceptions\UnauthorizedException;
use Illuminate\Support\Facades\Auth;

class BusinessAbstract
{
    public function can(string $permission): void
    {
        if(!Auth::user()->can($permission)){
            throw new UnauthorizedException(403);
        }
    }

    public function canDo(string $permission): bool
    {
        return Auth::user()->can($permission);
    }
}
