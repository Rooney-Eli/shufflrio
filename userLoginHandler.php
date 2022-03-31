<?php
session_start();

require_once './usersDao.php';

$username = htmlspecialchars($_POST['username-input']);
$password = htmlspecialchars($_POST['password-input']);

$usersDao = new usersDao();
$user = $usersDao->fetchUserByUsername($username);

$_SESSION['attempted-username'] = $_POST['username-input'];

if(strlen($username) < 1) {
    $_SESSION["error-message"] = 'invalidUsername';
    header("Location: /index.php");
    exit();
} else if ($user == false) {
    $_SESSION["error-message"] = 'invalidUsername';
    header("Location: /index.php");
    exit();
}

if(strlen($password) < 1) {
    $_SESSION["error-message"] = 'invalidPassword';
    header("Location: /index.php");
    exit();
} else if($user['password'] != $password) {
    $_SESSION["error-message"] = 'invalidPassword';
    header("Location: /index.php");
    exit();
}

$_SESSION['active-user'] = $username;
$_SESSION['active-user-id'] = $user['id'];
header("Location: /library.php");
exit();

