<?php

declare(strict_types=1);

namespace Shufflrio\Src\Php\Attributes;

use Shufflrio\Src\Php\HTTPMethod;
use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class Post extends Route {

    public function __construct(string $path) {
        parent::__construct($path, HTTPMethod::POST);
    }

}