<?php

namespace Shufflrio\Src\Php\Exceptions;

class NotBoundException extends \Exception {
    protected $message = "Dependency is not bound!";
}