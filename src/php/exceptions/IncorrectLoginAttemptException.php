<?php

namespace Shufflrio\Src\Php\Exceptions;

use Exception;

class IncorrectLoginAttemptException extends Exception {
    protected $message = "Login Attempt Failed!";
}