<?php

namespace App\Src\Php\Exceptions;

use Exception;

class IncorrectUsernameException extends Exception {
    protected $message = "Incorrect Username!";
}