<?php
class usersDao {

    private $host = "Awesomedb.net";
    private $db = "Awesome_db";
    private $user = "AwesomeUser";
    private $pass = "AwesomePass";

    public function getConnection () {
        try {
            return new PDO('mysql:host='. $this->host . ';dbname='. $this->db, $this->user, $this->pass);
        } catch (Exception $e) {

        }
    }

    function fetchUserByUsername($username) {
        try {
            $query = 'SELECT * FROM users WHERE username=:username';
            $db = $this->getConnection();
            $stmt = $db->prepare($query);
            $stmt->bindValue(':username', $username);
            $stmt->execute();
            return $stmt->fetch();
        } catch (Exception $e) {
            return false;
        }

    }

    function createUser($username, $password) {
        try {
            $query = 'INSERT INTO users (username, password) 
                    VALUES (:username, :password)';
            $db = $this->getConnection();
            $stmt = $db->prepare($query);
            $stmt->bindValue(':username', $username);
            $stmt->bindValue(':password', $password);
            $stmt->execute();
        } catch (Exception $e) {
        }
    }

}

