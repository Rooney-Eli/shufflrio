<?php

namespace App\Src\Php\Exceptions;

class NotBoundException extends \Exception {
    protected $message = "Dependency is not bound!";
}