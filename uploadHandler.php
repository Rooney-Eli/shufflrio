<?php
session_start();

require_once './songDao.php';

$name = '';
if(isset($_POST['upload-name-input'])) {
    $name = htmlspecialchars($_POST['upload-name-input']);
}

$artist = '';
if(isset($_POST['upload-artist-input'])) {
    $artist = htmlspecialchars($_POST['upload-artist-input']);
}

$album = '';
if(isset($_POST['upload-album-input'])) {
    $album = htmlspecialchars($_POST['upload-album-input']);
}

if(!isset($_SESSION['active-user-id'])) {
    header("Location: index.php");
    exit();
}

$uploadedFileURL = '';

if(isset($_POST['user']['avatar_url'])) {

    $uploadedFileURL = $_POST['user']['avatar_url'];
    $ownerId = $_SESSION['active-user-id'];
    require_once './songDao.php';
    $songDao = new songDao();
    $songDao->uploadSong($name, $artist, $album, $ownerId, $uploadedFileURL);
}

header("Location: /library.php");
exit();
