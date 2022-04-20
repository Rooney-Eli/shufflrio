<?php

declare(strict_types = 1);

namespace App\Src\Php\Views\Library;

class LibraryView {

    static public function render() {
        include __DIR__ . '/../../../resources/static/html/library/library.html';
    }
}