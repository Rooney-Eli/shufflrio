<?php

declare(strict_types = 1);

namespace Shufflrio\Src\Php\Views\Login;

class LoginView {
    static public function render() {
        include __DIR__ . '/../../../resources/static/html/login/login.html';
    }
}