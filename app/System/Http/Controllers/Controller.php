<?php

namespace App\System\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    const MESSAGE_KEY_SUCCESS = 'success';
    const MESSAGE_KEY_ERROR = 'error';
    const MESSAGE_KEY_WARNING = 'warning';
}
