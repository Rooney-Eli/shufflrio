<?php

declare(strict_types = 1);

require_once './src/php/ShufflrApp.php';
require_once './src/php/Config.php';
require_once './src/php/DotEnv.php';
require_once './src/php/di/Container.php';
require_once './src/php/controllers/LoginController.php';
require_once './src/php/controllers/LibraryController.php';
require_once './src/php/RequestRouter.php';
require_once './src/php/models/SongCacheEntity.php';
require_once './src/php/exceptions/RouteNotFoundException.php';
require_once './src/php/exceptions/ContainerException.php';
require_once './src/php/exceptions/NotFoundException.php';


use App\Src\ShufflrApp;
use App\Src\Di\Container;
use App\Src\Php\Config;
use App\Src\Php\Controllers\LibraryController;
use App\Src\Php\DotEnv;
use App\Src\Php\RequestRouter;
use App\Src\Php\Controllers\LoginController;


$dotEnv = new DotEnv("./../.env");
$dotEnv->load();

$ct = new Container();
$rr = new RequestRouter($ct);


try {
    $rr->registerRoutesFromControllerAttributes(
        [
            LoginController::class,
            LibraryController::class
        ]
    );
} catch (ReflectionException $e) {
    echo $e;
}

(new ShufflrApp(
    $ct,
    $rr,
    [
        'uri' => $_SERVER['REQUEST_URI'],
        'method' => $_SERVER['REQUEST_METHOD']
    ],
    new Config($_ENV)
))->run();


