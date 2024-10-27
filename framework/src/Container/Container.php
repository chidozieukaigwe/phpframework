<?php
namespace ChidoUkaigwe\Framework\Container;

use ChidoUkaigwe\Framework\Tests\DependentClass;
use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{

    private array $services = [];
    
    public function add(string $id, string|object $concrete = null)
    {
        if (null === $concrete) {

            if (!class_exists($id))
            {
                throw new ContainerException("Service $id could not be added");
            }

            $concrete = $id;
        }

        $this->services[$id] = $concrete;

    }

    public function get(string $id) 
    {
        if (!$this->has($id)){
            if (!class_exists($id))
            {
                throw new ContainerException("Service $id could not be resolved");
            }
            $this->add($id);
        }

        $object = $this->resolve($this->services[$id]);

        return $object;
    }

    public function has(string $id): bool
    {
        return array_key_exists($id, $this->services);
    }

    private function resolve ($class) 
    {
        // 1. initiate a reflection class (dump and check)
        $relfectionClass = new \ReflectionClass($class);
        // 2. Use Reflection to try to obtain a class constructor
        $constructor = $relfectionClass->getConstructor();
        // 3. If there is no constructor, simply instantiate
        if (null === $constructor) {
            return $relfectionClass->newInstance();
        }
        // 4. Get the constructor parameters
        $constructorParams = $constructor->getParameters();

        // 5. Obtain dependencies
        $classDependencies = $this->resolveClassDependencies($constructorParams);
        // 6. Instantiate with dependencies
        $service = $relfectionClass->newInstanceArgs($classDependencies);
        // 7. Return the object
        return $service;
    }

    private function resolveClassDependencies(array $reflectionParameters):array
    {
        // 1. Initialize empty dependencies array (required by newInstance Args)
        $classDependencies = [];
        // 2. Try to locate and instantiate each parameter
        /**
         * @var \ReflectionParameter $parameter
         */
        foreach ($reflectionParameters as $parameter) {
        //  Get the parameters ReflectionNamedType as $serviceType
        $serviceType = $parameter->getType();
        //  Try to instantiate using $serviceType's name
        $service = $this->get($serviceType->getName());
        //  Add the service to the classDependencies array
        $classDependencies[] = $service;
    }
        // 3. Retrun the classdependencies array
    return $classDependencies;
    }
}