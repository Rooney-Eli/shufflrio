<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Library</title>
    <link rel="stylesheet" href="style.css"/>
    <link rel="stylesheet" href="upload-style.css"/>
    <script src="https://app.simplefileupload.com/buckets/3af1ef5c6164ddf51093608281bc8a5f.js"></script>
</head>
<body>

<div class="page-north">
</div>

<div class="page-center-column">
    <div class="prompt-container">
        <div class="upload">
            <form class="login-form" action="uploadHandler.php" enctype="multipart/form-data" method="post">
                <label id="banner-name">Upload</label>

                <label id="upload-name-label" for="upload-name-input">Name</label>
                <input type="text" id="upload-name-input" class="text-input-box" name="upload-name-input" placeholder="...">

                <label id="upload-artist-label" for="upload-artist-input">Artist</label>
                <input type="text" id="upload-artist-input" class="text-input-box" name="upload-artist-input" placeholder="...">

                <label id="upload-album-label" for="upload-album-input">Album</label>
                <input type="text" id="upload-album-input" class="text-input-box" name="upload-album-input" placeholder="...">

                <label id="upload-file-label" for="upload-file">Select a file:</label>
                <input type="file" id="upload-file" name="upload-file" accept=".mp3">
                <input type="hidden" id="user_avatar_url" name="user[avatar_url]" class="simple-file-upload">

                <input id="submit-btn" class="submit-button" type="submit" value="Upload">
                <input id="cancel-btn" class="submit-button" type="submit" formaction="/library.php" value="Cancel">

            </form>
        </div>
</div>

<div class="page-south">
<div class="page-east">
<div class="page-west">
</body>
</html>
