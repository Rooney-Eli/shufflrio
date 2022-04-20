<?php

declare(strict_types = 1);

namespace Shufflrio\Src\Php\Repositories\Dao;

use Shufflrio\Src\Php\ShufflrApp;
use Shufflrio\Src\Php\Database;
use Shufflrio\Src\Php\Exceptions\NotFoundException;
use Shufflrio\Src\Php\Models\SongCacheEntity;
use PDO;

require_once __DIR__ . '/../../models/SongCacheEntity.php';

class SongDAO {

    private Database $db;

    public function __construct() {
        $this->db = ShufflrApp::db();
    }


    function createSong(SongCacheEntity $songCacheEntity) {
        $query = 'INSERT INTO songs (ownerId, name, artist, album, filepath) 
                    VALUES (:ownerId, :name, :artist, :album, :filepath)';

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':ownerId', $songCacheEntity->ownerId, PDO::PARAM_INT);
        $stmt->bindValue(':name', $songCacheEntity->name);
        $stmt->bindValue(':artist', $songCacheEntity->artist);
        $stmt->bindValue(':album', $songCacheEntity->album);
        $stmt->bindValue(':filepath', $songCacheEntity->filepath);


        $stmt->execute();

    }

    /**
     * @throws NotFoundException
     */
    function fetchSongById(int $id): SongCacheEntity {
        $query = 'SELECT * FROM songs WHERE id=:id';

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':id', $id);

        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if($data == false) {
            throw new NotFoundException("Couldn't fetch song with id $id!");
        }

        return new SongCacheEntity(
            id: $data['id'],
            ownerId: $data['ownerId'],
            name: $data['name'],
            artist: $data['artist'],
            album: $data['album'],
            filepath: $data['filepath']
        );

    }

    /**
     * @throws NotFoundException
     */
    public function fetchAllSongsForUser(int $userId): array {
        $query = 'SELECT * FROM songs WHERE ownerId=:userId';

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':userId', $userId);

        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);


        if($data == false) {
            throw new NotFoundException("Couldn't fetch all songs for user with id $userId!");
        }

        return array_map(
            fn ($it) => new SongCacheEntity(
                id: $it['id'],
                ownerId: $it['ownerId'],
                name: $it['name'],
                artist: $it['artist'],
                album: $it['album'],
                filepath: $it['filepath']
            ),
            $data
        );

    }

}