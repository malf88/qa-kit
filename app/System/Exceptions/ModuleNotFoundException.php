<?php

namespace App\System\Exceptions;

use Exception;

class ModuleNotFoundException extends Exception
{
    public function __construct(string $message = "Module not found")
    {
        parent::__construct($message);
    }
}
