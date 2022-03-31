<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Library</title>
    <link rel="stylesheet" href="style.css"/>
    <link rel="stylesheet" href="library-style.css"/>
</head>
<body>

<div class="page-north">
    <div class="north-container">
        <h4 id="banner-name">Shufflr</h4>
        <h5 id="banner-phrase">mix it up</h5>
        <form id ="logout-form" action="logoutHandler.php" method="post">
            <label id="logged-in-label">Logged&nbspin&nbspas: <?php
            if(isset($_SESSION['active-user'])) {
                echo $_SESSION['active-user'];
            } else {
                echo 'unknown';
            }?></label>
            <button id="logout-button" type="submit" value="Logout">Logout</button>
            <button id="upload-button" type="submit" value="Upload" formaction="uploadSong.php">Upload</button>
        </form>
    </div>
</div>

<div class="page-center-column">
    <?php
    require_once './songDao.php';
        $activeUserId = $_SESSION['active-user-id'];
        $songDao = new songDao();
        $songs = $songDao->getSongsForUserId($activeUserId);

        foreach ($songs as $song) {
            $album = $song['album'] ?? '';
            $artist = $song['artist'] ?? '';
            $name = $song['name'] ?? '';
            $filepath = $song['filepath'] ?? '';
            $string =
                "<div class='song-view'>" .
                "<p class='song-album'>$album</p>" .
                "<p class='song-title'>$name</p>" .
                "<p class='song-artist'>$artist</p>" .
                "<audio controls preload='media'><source src='$filepath' type='audio/mp3'/></audio></div>"
            ;


            echo $string;
        }

    ?>


</div>

<div class="page-south">



<div class="page-east">
<div class="page-west">

</div>
</body>
</html>
