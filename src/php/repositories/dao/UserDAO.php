<?php

declare(strict_types = 1);

namespace App\Src\Php\Repositories\Dao;

use App\ShufflrApp;
use App\Src\Php\Database;
use App\Src\Php\Exceptions\NotFoundException;
use App\Src\Php\Models\UserCacheEntity;
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

        $stmt->bindValue(':username', $userCacheEntity->username);
        $stmt->bindValue(':password', $userCacheEntity->password);

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