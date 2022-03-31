<?php
session_start();

require_once './usersDao.php';

$newUsername = htmlspecialchars($_POST['username-input']);
$newPassword = htmlspecialchars($_POST['password-input']);

$usersDao = new usersDao();
$user = $usersDao->fetchUserByUsername($newUsername);

$_SESSION['attempted-new-username'] = $_POST['username-input'];
$_SESSION['attempted-new-password'] = $_POST['password-input'];

if(strlen($newUsername) < 1) {
    $_SESSION["error-message"] = 'invalidNewUsername';
    header("Location: /create.php");
    exit();
} else if ($user == true) {
    $_SESSION["error-message"] = 'invalidNewUsername';
    header("Location: /create.php");
    exit();
}

if(strlen($newPassword) < 1) {
    $_SESSION["error-message"] = 'invalidNewPassword';
    header("Location: /create.php");
    exit();
}

$usersDao->createUser($newUsername, $newPassword);

header("Location: /index.php");
exit();