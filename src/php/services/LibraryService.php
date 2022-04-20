<?php

declare(strict_types = 1);

namespace Shufflrio\Src\Php\Services;

use Shufflrio\Src\Php\Exceptions\NotFoundException;
use Shufflrio\Src\Php\Models\SongDomainEntity;
use Shufflrio\Src\Php\Repositories\SongRepository;

class LibraryService {

    public function __construct(
        private readonly SongRepository $songRepository
    ) {}


    public function addSong(SongDomainEntity $songDomainEntity) {
        $this->songRepository->addSong($songDomainEntity);
    }

    /**
     * @throws NotFoundException
     */
    public function getSongById(int $songId): SongDomainEntity {
        return $this->songRepository->getSongById($songId);
    }

    /**
     * @throws NotFoundException
     */
    public function getAllSongsForUser(int $userId): array {
        return $this->songRepository->getAllSongsForUser($userId);
    }


}