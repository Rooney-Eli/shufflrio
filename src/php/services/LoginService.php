<?php

declare(strict_types = 1);

namespace Shufflrio\Src\Php\Services;

use ShufflrioSrc\Php\Exceptions\IncorrectLoginAttemptException;
use ShufflrioSrc\Php\Exceptions\IncorrectUsernameException;
use ShufflrioSrc\Php\Exceptions\NotFoundException;
use ShufflrioSrc\Php\Models\UserDomainEntity;
use ShufflrioSrc\Php\Repositories\UsersRepository;
use Exception;


class LoginService {
    public function __construct(
        private readonly UsersRepository $usersRepository
    ) {}


    /**
     * @throws IncorrectUsernameException
     * @throws IncorrectLoginAttemptException
     */
    public function authenticateUser(UserDomainEntity $userLoginAttempt): int {
        $usernameAttempt = $userLoginAttempt->username;
        $userId = -1;
        try {
            $userDataForUsername = $this->getUserByName($usernameAttempt);
        } catch (NotFoundException) {
            throw new IncorrectUsernameException("Username $usernameAttempt doesn't exist!");
        }

        if(!password_verify($userLoginAttempt->password, $userDataForUsername->password)){
            throw new IncorrectLoginAttemptException("Password for $usernameAttempt didn't match!");
        }

        return $userDataForUsername->id;
    }



    /**
     * @throws NotFoundException
     */
    public function getUserByName(string $username): UserDomainEntity {
        return $this->usersRepository->getUserByName($username);
    }

    /**
     * @throws NotFoundException
     */
    public function getUserIdByName(string $username): int {
        return $this->usersRepository->getUserIdByName($username);
    }



    public function createUser(UserDomainEntity $userDomainEntity) {
        $this->usersRepository->createUser($userDomainEntity);
    }


}