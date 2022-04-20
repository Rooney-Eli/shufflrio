<?php

declare(strict_types = 1);

namespace Shufflrio\Src\Php\Controllers;

use Shufflrio\Src\Php\Attributes\Get;
use Shufflrio\Src\Php\Attributes\Post;
use Shufflrio\Src\Php\Exceptions\IncorrectLoginAttemptException;
use Shufflrio\Src\Php\Exceptions\IncorrectUsernameException;
use Shufflrio\Src\Php\Exceptions\NotFoundException;
use Shufflrio\Src\Php\Models\UserDomainEntity;
use Shufflrio\Src\Php\Services\LoginService;
use Shufflrio\Src\Php\Views\Library\LibraryView;
use Shufflrio\Src\Php\Views\Login\LoginView;
use http\Header;

class LoginController {

    public function __construct(
        private readonly LoginService $loginService
    ) {}

    // could make a totally different controller for this... or just put it where it kinda makes sense
    #[Get('/')]
    public function getDefaultPage() {
        if(isset($_COOKIE['id'])) {
            LibraryView::render();
            die();
        }
        LoginView::render();
    }



    #[Post('/authenticateUser')]
    public function loginUser() {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $username = $data['username'];
        $password = $data['password'];

        $userLoginAttempt = new UserDomainEntity(
            id: -1,
            username: $username,
            password: $password
        );

        $response = [];
        try {
            $userid = $this->loginService->authenticateUser($userLoginAttempt);
            $response['id'] = $userid;
            setcookie('id', strval($userid), strtotime('+30 days'));
        } catch (IncorrectUsernameException) {
            $response['error'] = 'username';
        } catch (IncorrectLoginAttemptException) {
            $response['error'] = 'password';
        }
        $responseJson = json_encode($response);
        header('Content-Type: application/json; charset=utf-8');
        echo $responseJson;
        die();
    }

    #[Post('/createUser')]
    public function createUser() {

        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $username = $data['username'];
        $password = $data['password'];

        $response = [];
        try {
            //user exists and can't be created
            $this->loginService->getUserByName($username);
            $response['error'] = 'username';
            $responseJson = json_encode($response);
            header('Content-Type: application/json; charset=utf-8');
            echo $responseJson;
            die();
        } catch (NotFoundException) {
            //can be created
            $userDomainEntity = new UserDomainEntity(
                -1,
                $username,
                $password
            );

            $this->loginService->createUser($userDomainEntity);

            try {
                $newUser = $this->loginService->getUserByName($username);
                $response['id'] = $newUser->id;
                $responseJson = json_encode($response);
                header('Content-Type: application/json; charset=utf-8');
                echo $responseJson;
                die();
            } catch (NotFoundException) {
                //silent
            }
        }


    }

}