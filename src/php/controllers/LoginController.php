<?php

declare(strict_types = 1);

namespace App\Src\Php\Controllers;

use App\Src\Php\Attributes\Get;
use App\Src\Php\Attributes\Post;
use App\Src\Php\Exceptions\IncorrectLoginAttemptException;
use App\Src\Php\Exceptions\IncorrectUsernameException;
use App\Src\Php\Exceptions\NotFoundException;
use App\Src\Php\Models\UserDomainEntity;
use App\Src\Php\Services\LoginService;
use App\Src\Php\Views\Library\LibraryView;
use App\Src\Php\Views\Login\LoginView;
use http\Header;

class LoginController {

    public function __construct(
        private readonly LoginService $loginService
    ) {}

    // could make a totally different controller for this... or just put it where it kinda makes sense
    #[Get('/')]
    public function getDefaultPage() {
//        if(isset($_COOKIE['id'])) {
//            LibraryView::render();
//            die();
//        }

        LoginView::render();


//        LibraryView::render();

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
            
        }


    }

}