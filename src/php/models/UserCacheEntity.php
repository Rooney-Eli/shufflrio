<?php

declare(strict_types = 1);

namespace App\Src\Php\Models;

class UserCacheEntity {

    public function __construct(
        readonly int $id,
        readonly string $username,
        readonly string $password,
    ) {}

}