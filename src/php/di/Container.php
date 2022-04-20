<?php

declare(strict_types = 1);

namespace Shufflrio\Src\Di;


require_once __DIR__ . '/../controllers/LoginController.php';
require_once __DIR__ . '/../services/LoginService.php';
require_once __DIR__ . '/../repositories/UsersRepository.php';
require_once __DIR__ . '/../repositories/dao/UserDAO.php';

require_once __DIR__ . '/../controllers/LibraryController.php';
require_once __DIR__ . '/../services/LibraryService.php';
require_once __DIR__ . '/../repositories/SongRepository.php';
require_once __DIR__ . '/../repositories/dao/SongDAO.php';


require_once __DIR__ . '/../exceptions/NotFoundException.php';
require_once __DIR__ . '/../exceptions/ContainerException.php';
require_once __DIR__ . '/../exceptions/IncorrectLoginAttemptException.php';
require_once __DIR__ . '/../exceptions/IncorrectUsernameException.php';


use ShufflrioSrc\php\exceptions\ContainerException;
use ShufflrioSrc\Php\Exceptions\NotFoundException;
use ReflectionClass;
use ReflectionException;
use ReflectionParameter;

class Container {

    private array $entries = [];

    /**
     * @throws ReflectionException | NotFoundException | ContainerException
     */
    public function get(string $id)  {
        if ($this->has($id)) {
            $entry = $this->entries[$id];

            if (is_callable($entry)) {
                return $entry($this);
            }

            $id = $entry;
        }

        return $this->resolve($id);
    }

    public function has(string $id): bool {
        return isset($this->entries[$id]);
    }

    public function set(string $id, callable $concrete) {
        $this->entries[$id] = $concrete;
    }

    /**
     * @throws ContainerException | ReflectionException | NotFoundException
     */
    public function resolve(string $id) {
        try {
            $reflectionClass = new ReflectionClass($id);
        } catch(ReflectionException $e) {
            throw new NotFoundException(message: $e->getMessage(), previous: $e);
        }

        if (! $reflectionClass->isInstantiable()) {
            throw new NotFoundException('Class "' . $id . '" is not instantiable');
        }

        $constructor = $reflectionClass->getConstructor();

        if (! $constructor) {
            return new $id;
        }

        $parameters = $constructor->getParameters();

        if (! $parameters) {
            return new $id;
        }

        $dependencies = array_map(
            function (ReflectionParameter $param) use ($id) {
                $name = $param->getName();
                $type = $param->getType();

                if (! $type) {
                    throw new ContainerException(
                        'Failed to resolve class "' . $id . '" because param "' . $name . '" is missing a type hint'
                    );
                }

                if ($type instanceof \ReflectionUnionType) {
                    throw new ContainerException(
                        'Failed to resolve class "' . $id . '" because of union type for param "' . $name . '"'
                    );
                }

                if ($type instanceof \ReflectionNamedType && ! $type->isBuiltin()) {
                    return $this->get($type->getName());
                }

                throw new ContainerException(
                    'Failed to resolve class "' . $id . '" because invalid param "' . $name . '"'
                );
            },
            $parameters
        );

        return $reflectionClass->newInstanceArgs($dependencies);
    }

}