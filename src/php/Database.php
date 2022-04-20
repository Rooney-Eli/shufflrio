<?php

namespace Shufflrio\Src\Php;

use PDO;
use PDOException;
use PDOStatement;

echo "Hello from database post use";

class Database {
//    protected PDO $pdo;
//
//    public function __construct(array $config) {
//
//        try {
//            $this->pdo = new PDO(
//                $config['driver'] . ':host=' . $config['host'] . ';dbname=' . $config['database'],
//                $config['user'],
//                $config['pass']
//            );
//        } catch (PDOException $e) {
//            throw new PDOException($e->getMessage(), (int) $e->getCode());
//        }
//    }
//
//    public function prepare(string $query): bool|PDOStatement {
//        return $this->pdo->prepare($query);
//    }
//
}