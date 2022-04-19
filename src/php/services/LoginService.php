<?php

declare(strict_types = 1);

namespace App\Src\Php\Services;

use App\Src\Php\Exceptions\IncorrectLoginAttemptException;
use App\Src\Php\Exceptions\IncorrectUsernameException;
use App\Src\Php\Exceptions\NotFoundException;
use App\Src\Php\Models\UserDomainEntity;
use App\Src\Php\Repositories\UsersRepository;
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
        try {
            $userDataForUsername = $this->getUserByName($usernameAttempt);
        } catch (NotFoundException) {
            throw new IncorrectUsernameException("Username $usernameAttempt doesn't exist!");
        }

        if($userLoginAttempt->password !== $userDataForUsername->password) {
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


    public function validateUsername(string $username): bool {
        if(strlen($username) == 0 ) return false;
        return true;
    }

    public function validatePassword(string $password): bool {
        if(strlen($password) == 0 ) return false;
        return true;
    }

}