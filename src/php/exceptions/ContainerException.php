<?php

namespace App\Src\Php\Exceptions;

use Exception;
use Throwable;

class ContainerException extends Exception {
    protected $message = "Can't instantiate class";
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}