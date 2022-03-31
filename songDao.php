<?php
class songDao {

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

    public function getSongsForUserId($id) {
        try {
            $query = 'SELECT * FROM songs WHERE ownerId=:ownerId';
            $db = $this->getConnection();
            $stmt = $db->prepare($query);
            $stmt->bindValue(':ownerId', $id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return false;
        }
    }

    public function uploadSong( $name, $artist, $album, $ownerId, $filepath) {
        try {
            $query = 'INSERT INTO songs (name, artist, album, ownerId, filepath) 
                    VALUES (:name, :artist, :album, :ownerId, :filepath)';
            $db = $this->getConnection();
            $stmt = $db->prepare($query);
            $stmt->bindValue(':name', $name);
            $stmt->bindValue(':artist', $artist);
            $stmt->bindValue(':album', $album);
            $stmt->bindValue(':ownerId', $ownerId);
            $stmt->bindValue(':filepath', $filepath);
            $stmt->execute();
        } catch (Exception $e) {
        }
    }

}