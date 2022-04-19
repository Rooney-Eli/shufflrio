<?php

declare(strict_types = 1);

namespace App\Src\Php\Models;

class SongCacheEntity {

    public function __construct(
        readonly int $id,
        readonly int $ownerId,
        readonly string $name,
        readonly string $artist,
        readonly string $album,
        readonly string $filepath
    ) {}


}