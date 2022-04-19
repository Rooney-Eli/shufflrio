<?php

declare(strict_types = 1);

require_once 'ShufflrApp.php';
require_once 'Config.php';
require_once './DotEnv.php';
require_once './di/Container.php';
require_once './controllers/LoginController.php';
require_once './controllers/LibraryController.php';
require_once './RequestRouter.php';
require_once './models/SongCacheEntity.php';
require_once './exceptions/RouteNotFoundException.php';
require_once './exceptions/ContainerException.php';
require_once './exceptions/NotFoundException.php';


use App\ShufflrApp;
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


