<?php

namespace App\Src\Php\Exceptions;

class RouteNotFoundException extends \Exception {
    protected $message = '404 Not Found';
}