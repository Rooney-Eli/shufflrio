<?php

namespace App\Src\Php\Exceptions;

class ViewNotFoundException extends \Exception {
    protected $message = 'View not found';
}