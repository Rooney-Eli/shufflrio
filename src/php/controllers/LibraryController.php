<?php

declare(strict_types = 1);

namespace Shufflrio\Src\Php\Controllers;

use Shufflrio\Src\Php\Attributes\Get;
use Shufflrio\Src\Php\Attributes\Post;
use Shufflrio\Src\Php\Exceptions\NotFoundException;
use Shufflrio\Src\Php\Models\SongDomainEntity;
use Shufflrio\Src\Php\Services\LibraryService;


class LibraryController {

    public function __construct(
        private readonly LibraryService $libraryService
    ) {}


    #[Post('/uploadSong')]
    public function uploadSong() {

        if(!isset($_COOKIE['id'])) {
            echo http_response_code(401); //unauthorized
            die();
        }

        $ownerId = intval($_COOKIE['id']);

        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $name = $data['title'];
        $artist = $data['artist'];
        $album = $data['album'];
        $filepath = $data['filepath'];

        var_dump($ownerId);
        die();

        $songDomainEntity = new SongDomainEntity(
            ownerId: $ownerId,
            songId: -1,
            name: $name,
            artist: $artist,
            album: $album,
            filepath: $filepath,
        );

        $this->libraryService->addSong($songDomainEntity);


        $responseJson = json_encode($songDomainEntity);
        header('Content-Type: application/json; charset=utf-8');
        echo $responseJson;

    }




    #[Get('/getAllSongs')]
    public function getAllSongsForUser() {

        if(!isset($_COOKIE['id'])) {
            echo http_response_code(401); //unauthorized
            die();
        }

        $cookieId = $_COOKIE['id'];
        $ownerId = (int)$cookieId;

        try{
            $responseJson = json_encode($this->libraryService->getAllSongsForUser($ownerId));

            header('Content-Type: application/json; charset=utf-8');
            echo $responseJson;
        } catch (NotFoundException) {
            $responseJson = json_encode([]);
            header('Content-Type: application/json; charset=utf-8');
            echo $responseJson;
        }

    }


}