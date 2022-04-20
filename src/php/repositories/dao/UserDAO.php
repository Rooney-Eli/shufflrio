<?php

declare(strict_types = 1);

namespace Shufflrio\Src\Php\Repositories\Dao;

use ShufflrioShufflrApp;
use ShufflrioSrc\Php\Database;
use ShufflrioSrc\Php\Exceptions\NotFoundException;
use ShufflrioSrc\Php\Models\UserCacheEntity;
use PDO;

require_once __DIR__ . '/../../models/UserCacheEntity.php';

class UserDAO {

    private Database $db;

    public function __construct() {
        $this->db = ShufflrApp::db();
    }

    function createUser(UserCacheEntity $userCacheEntity) {
        $query = 'INSERT INTO users (username, password) 
                    VALUES (:username, :password)';

        $stmt = $this->db->prepare($query);


        $hashOptions = [ 'cost' => 12 ];
        $hashedPass = password_hash($userCacheEntity->password, PASSWORD_BCRYPT, $hashOptions);

        $stmt->bindValue(':username', $userCacheEntity->username);
        $stmt->bindValue(':password', $hashedPass);

        $stmt->execute();
    }

    /**
     * @throws NotFoundException
     */
    function fetchUserByUsername(string $username): UserCacheEntity {
        $query = 'SELECT * FROM users WHERE username=:username';

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':username', $username);

        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if($data == false) {
            throw new NotFoundException("Couldn't fetch info for user with username $username!");
        }

        return new UserCacheEntity(
            id: $data['id'],
            username: $data['username'],
            password: $data['password']
        );

    }

}