<?php


declare(strict_types=1);

namespace App\Src\Php\Attributes;


use App\Src\Php\HTTPMethod;
use Attribute;

#[Attribute]
class Route {

    public function __construct(
        public string $path,
        public HTTPMethod $method = HTTPMethod::GET
    ) {

    }
}