<?php

declare(strict_types = 1);

namespace Shufflrio\Src\Php\Repositories;

use Shufflrio\Src\Php\Exceptions\NotFoundException;
use Shufflrio\Src\Php\Models\UserDomainEntity;
use Shufflrio\Src\Php\Models\UserMapper;
use Shufflrio\Src\Php\Repositories\Dao\UserDAO;

require_once __DIR__ . '/../models/UserMapper.php';

class UsersRepository {

    public function __construct(
        private readonly UserDAO $userDao,
        private readonly UserMapper $userMapper,
    ) {}


    /**
     * @throws NotFoundException
     */
    public function getUserByName(string $username): UserDomainEntity {
        return $this->userMapper->mapCacheEntityToDomainEntity(
            $this->userDao->fetchUserByUsername($username)
        );
    }

    /**
     * @throws NotFoundException
     */
    public function getUserIdByName(string $username): int {
        return $this->userDao->fetchUserByUsername($username)->id;

    }

    public function createUser(UserDomainEntity $userDomainEntity) {
        $this->userDao->createUser($this->userMapper->mapDomainEntityToCacheEntity($userDomainEntity));
    }




}