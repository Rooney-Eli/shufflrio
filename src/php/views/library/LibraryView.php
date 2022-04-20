<?php

declare(strict_types = 1);

namespace Shufflrio\Src\Php\Views\Library;

class LibraryView {

    static public function render() {
        include __DIR__ . '/../../../resources/static/html/library/library.html';
    }
}