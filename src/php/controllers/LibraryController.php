<?php

declare(strict_types = 1);

namespace Shufflrio\Src\Php\Controllers;

use App\Src\Php\Attributes\Get;
use App\Src\Php\Attributes\Post;
use App\Src\Php\Exceptions\NotFoundException;
use App\Src\Php\Models\SongDomainEntity;
use App\Src\Php\Services\LibraryService;


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

        if(isset($_POST["songName"])) {
            $songName = $_POST["songName"];
        } else {
            echo http_response_code(400); //bad request
            die();
        }

        if(isset($_POST["songArtist"])) {
            $songArtist = $_POST["songArtist"];
        } else {
            echo http_response_code(400); //bad request
            die();
        }

        if(isset($_POST["songAlbum"])) {
            $songAlbum = $_POST["songAlbum"];
        } else {
            echo http_response_code(400); //bad request
            die();
        }



        if(isset($_FILES['songFile'])) {
            if($_FILES['songFile']['error'] == 0) {
                $target_dir = __DIR__ . '/../../uploads/songs/"';
                $songFilePath = uniqid() . ".mp3";
                move_uploaded_file($_FILES['songFile']['tmp_name'], $target_dir . $songFilePath);
                $filePath = $target_dir . $songFilePath;
            } else {
                echo http_response_code(400); //bad request
                die();
            }
        } else {
            echo http_response_code(400); //bad request
            die();
        }


        $songDomainEntity = new SongDomainEntity(
            ownerId: $ownerId,
            songId: -1,
            name: $songName,
            artist: $songArtist,
            album: $songAlbum,
            filepath: $filePath,
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
            http_response_code(404);
            die();
        }

    }


}