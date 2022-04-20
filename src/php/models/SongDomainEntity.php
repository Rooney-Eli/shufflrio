<?php

declare(strict_types = 1);

namespace Shufflrio\Src\Php\Models;

class SongDomainEntity {

    public function __construct(
        readonly int $ownerId,
        readonly int $songId,
        readonly string $name,
        readonly string $artist,
        readonly string $album,
        readonly string $filepath
    ) {}


}