<?php

declare(strict_types = 1);
require_once './src/php/ShufflrApp.php';
require_once './src/php/Config.php';
require_once './src/php/DotEnv.php';
require_once './src/php/di/Container.php';
require_once './src/php/RequestRouter.php';
require_once './src/php/controllers/LoginController.php';
require_once './src/php/controllers/LibraryController.php';
require_once './src/php/models/SongCacheEntity.php';
require_once './src/php/exceptions/RouteNotFoundException.php';
require_once './src/php/exceptions/ContainerException.php';
require_once './src/php/exceptions/NotFoundException.php';


use Shufflrio\Src\Php\ShufflrApp;
use Shufflrio\Src\Php\Config;
use Shufflrio\Src\Php\DotEnv;
use Shufflrio\Src\Di\Container;
use Shufflrio\Src\Php\RequestRouter;


use Shufflrio\Src\Php\Controllers\LibraryController;
use Shufflrio\Src\Php\Controllers\LoginController;


$dotEnv = new DotEnv("../src/.env");
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


