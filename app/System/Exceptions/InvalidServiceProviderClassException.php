<?php

namespace App\System\Exceptions;

use Exception;
use JetBrains\PhpStorm\Pure;

class InvalidServiceProviderClassException extends Exception
{


    #[Pure] public function __construct(string $message = "Class name not is service provider class valid.", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
