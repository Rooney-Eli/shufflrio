<?php

declare(strict_types = 1);

namespace Shufflrio\Src\Php\Repositories;

require_once __DIR__ . '/../models/SongMapper.php';

use ShufflrioSrc\Php\Exceptions\NotFoundException;
use ShufflrioSrc\Php\Models\SongDomainEntity;
use ShufflrioSrc\Php\Models\SongMapper;
use ShufflrioSrc\Php\Repositories\Dao\SongDAO;

class SongRepository {

    public function __construct(
        private readonly SongDAO $songDao,
        private readonly SongMapper $songMapper,
    ) {}

    public function addSong(SongDomainEntity $songDomainEntity) {
        $ownerId = 5; //TODO: Get this from the session ID eventually
        $this->songDao->createSong(
            $this->songMapper->mapDomainEntityToCacheEntity($songDomainEntity, $ownerId)
        );

    }

    /**
     * @throws NotFoundException
     */
    public function getSongById(int $id): SongDomainEntity {
        $fetchedSong = $this->songDao->fetchSongById($id);
        return $this->songMapper->mapCacheEntityToDomainEntity($fetchedSong);
    }

    /**
     * @throws NotFoundException
     */
    public function getAllSongsForUser($userId): array|false {
        $fetchedSongs = $this->songDao->fetchAllSongsForUser($userId);
        return $this->songMapper->mapArrayOfCacheEntitiesToDomainEntities($fetchedSongs);
    }


}