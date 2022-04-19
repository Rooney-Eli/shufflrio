<?php

declare(strict_types=1);

namespace App\Src\Php;


enum HTTPMethod: string {

    case GET = 'get';
    case POST = 'post';

}