<?php

namespace Shufflrio\Src\Php\Exceptions;


use Throwable;

class NotFoundException extends \Exception {
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}