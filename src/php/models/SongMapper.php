<?php

declare(strict_types = 1);

namespace App\Src\Php\Models;

require_once __DIR__ . '/SongCacheEntity.php';
require_once __DIR__ . '/SongDomainEntity.php';

class SongMapper {
    function mapCacheEntityToDomainEntity(SongCacheEntity $cacheEntity): SongDomainEntity {
        return new SongDomainEntity(
            ownerId: $cacheEntity->ownerId,
            songId: $cacheEntity->id,
            name: $cacheEntity->name,
            artist: $cacheEntity->artist,
            album: $cacheEntity->album,
            filepath: $cacheEntity->filepath
        );
    }

    function mapDomainEntityToCacheEntity(SongDomainEntity $domainEntity, int $ownerId): SongCacheEntity {
        return new SongCacheEntity(
            id: -1,
            ownerId: $ownerId,
            name: $domainEntity->name,
            artist: $domainEntity->artist,
            album: $domainEntity->album,
            filepath: $domainEntity->filepath
        );
    }

    function mapArrayOfCacheEntitiesToDomainEntities(array $cacheEntities): array {
        return array_map(
            fn ($it) => $this->mapCacheEntityToDomainEntity($it),
            $cacheEntities
        );
    }
}