<?php

declare(strict_types = 1);

namespace Shufflrio\Src\Php;

use http\Exception\InvalidArgumentException;
use RuntimeException;

class DotEnv {

    public function __construct(
        private readonly string $path
    ) {
        if(!file_exists($this->path)) {
            throw new InvalidArgumentException("Invalid path to .env file: $path");
        }
    }


    public function load() {
        if(!is_readable($this->path)) {
            throw new RuntimeException("Path not readable: $this->path");
        }

        $lines = file($this->path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if(str_starts_with(trim($line), '#')) {
                continue;
            }

            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);


//            if(!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
                putenv("$name=$value");
                $_ENV[$name] = $value;
                $_SERVER[$name] = $value;

//            }
        }
    }

}