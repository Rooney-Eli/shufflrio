<?php

namespace App;

//require_once './Database.php';
//
//use App\Src\Di\Container;
//use App\Src\Php\Database;
//use App\Src\Php\Exceptions\ContainerException;
//use App\Src\Php\Exceptions\RouteNotFoundException;
//use App\Src\Php\Exceptions\NotFoundException;
//use App\Src\Php\RequestRouter;
//use App\Src\Php\Config;
//use ReflectionException;
//
//
//class ShufflrApp {
//    private static Database $db;
//
//    public function __construct(
//        protected Container $container,
//        protected RequestRouter $router,
//        protected array $request,
//        protected Config $config
//    ) {
//        static::$db = new Database($config->db ?? []);
//    }
//
//    public static function db(): Database {
//        return static::$db;
//    }
//
//    public function run() {
//        try {
//            $this->router->resolve($this->request['uri'], strtolower($this->request['method']));
//        } catch (RouteNotFoundException|ReflectionException|ContainerException|NotFoundException $e) {
//            http_response_code(404);
//        }
//    }
//}