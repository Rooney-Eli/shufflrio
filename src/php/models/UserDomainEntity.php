<?php

namespace Shufflrio\Src\Php\Models;

class UserDomainEntity {

    public function __construct(
        readonly int $id,
        readonly string $username,
        readonly string $password,
    ) {}
}