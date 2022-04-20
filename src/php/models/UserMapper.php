<?php

declare(strict_types = 1);

namespace Shufflrio\Src\Php\Models;

require_once __DIR__ . '/UserCacheEntity.php';
require_once __DIR__ . '/UserDomainEntity.php';

class UserMapper {
    function mapCacheEntityToDomainEntity(UserCacheEntity $cacheEntity): UserDomainEntity {
        return new UserDomainEntity(
            id: $cacheEntity->id,
            username: $cacheEntity->username,
            password: $cacheEntity->password,
        );
    }

    function mapDomainEntityToCacheEntity(UserDomainEntity $domainEntity): UserCacheEntity {
        return new UserCacheEntity(
            id: -1,
            username: $domainEntity->username,
            password: $domainEntity->password,
        );
    }
}