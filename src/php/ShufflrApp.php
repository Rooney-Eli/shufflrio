<?php

declare(strict_types = 1);

namespace Shufflrio\Src\Php;

require_once './Database.php';

use Shufflrio\Src\Di\Container;
use Shufflrio\Src\Php\Database;
use Shufflrio\Src\Php\Exceptions\ContainerException;
use Shufflrio\Src\Php\Exceptions\RouteNotFoundException;
use Shufflrio\Src\Php\Exceptions\NotFoundException;
use Shufflrio\Src\Php\RequestRouter;
use Shufflrio\Src\Php\Config;
use ReflectionException;


class ShufflrApp {
    private static Database $db;

    public function __construct(
        protected Container $container,
        protected RequestRouter $router,
        protected array $request,
        protected Config $config
    ) {
        static::$db = new Database($config->db ?? []);
    }

    public static function db(): Database {
        return static::$db;
    }

    public function run() {
        try {
            $this->router->resolve($this->request['uri'], strtolower($this->request['method']));
        } catch (RouteNotFoundException|ReflectionException|ContainerException|NotFoundException $e) {
            http_response_code(404);
        }
    }
}