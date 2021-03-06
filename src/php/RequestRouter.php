<?php

declare(strict_types = 1);

namespace Shufflrio\Src\Php;

require_once './src/php/HTTPMethod.php';
require_once './src/php/attributes/Route.php';
require_once './src/php/attributes/Get.php';
require_once './src/php/attributes/Post.php';

require_once './src/php/exceptions/RouteNotFoundException.php';

require_once './src/php/controllers/LoginController.php';
require_once './src/php/controllers/LibraryController.php';

require_once './src/php/repositories/dao/SongDAO.php';

require_once './src/php/views/library/LibraryView.php';
require_once './src/php/views/login/LoginView.php';

use Shufflrio\Src\Di\Container;
use Shufflrio\Src\Php\Attributes\Route;
use Shufflrio\Src\Php\Exceptions\ContainerException;
use Shufflrio\Src\Php\Exceptions\RouteNotFoundException;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionException;


class RequestRouter {

    private array $routes = [];

    public function __construct(private Container $container){

    }


    /**
     * @throws ReflectionException
     */
    public function registerRoutesFromControllerAttributes(array $controllers) {
        foreach ($controllers as $controller) {
            $reflectionController = new ReflectionClass($controller);

            foreach ($reflectionController->getMethods() as $method) {
                $attributes = $method->getAttributes(Route::class, ReflectionAttribute::IS_INSTANCEOF);

                foreach ($attributes as $attribute) {
                    $route = $attribute->newInstance();

                    $this->register($route->method->value, $route->path, [$controller, $method->getName()]);
                }
            }
        }
    }


    public function register(string $requestMethod, string $route, callable|array $action): self {
        $this->routes[$requestMethod][$route] = $action;
        return $this;
    }

    public function get(string $route, callable|array $action): self {
        return $this->register('get', $route, $action);
    }

    public function post(string $route, callable|array $action): self {
        return $this->register('post', $route, $action);
    }

    public function routes(): array {
        return $this->routes;
    }

    /**
     * @param string $requestUri
     * @param string $requestMethod
     * @return false|mixed
     * @throws ContainerException
     * @throws Exceptions\NotFoundException
     * @throws ReflectionException
     * @throws RouteNotFoundException
     */
    public function resolve(string $requestUri, string $requestMethod): mixed {
        $route = explode('?', $requestUri)[0];
        $action = $this->routes[$requestMethod][$route] ?? null;

        if(!$action) {
            throw new RouteNotFoundException();
        }

        if(is_callable($action)) {
            return call_user_func($action);
        }

        if(is_array($action)){
            [$class, $method] = $action;

            if(class_exists($class)) {
                $class = $this->container->get($class);

                if(method_exists($class, $method)) {
                    return call_user_func_array([$class, $method], []);
                }
            }

        }

        throw new RouteNotFoundException();
    }
}