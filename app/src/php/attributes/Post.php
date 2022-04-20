<?php

declare(strict_types=1);

namespace App\Src\Php\Attributes;

use App\Src\Php\HTTPMethod;
use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class Post extends Route {

    public function __construct(string $path) {
        parent::__construct($path, HTTPMethod::POST);
    }

}