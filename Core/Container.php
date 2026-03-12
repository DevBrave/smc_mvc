<?php

namespace Core;

use ReflectionClass;
use ReflectionNamedType;

class Container
{
    protected $bindings = [];
    protected $instances = []; // <--- The Cache

    public function bind($key, $resolver)
    {
        $this->bindings[$key] = $resolver;
    }

    public function resolve($key)
    {

        // 1. Check Cache: Do we already have this object?
        if (isset($this->instances[$key])) {
            return $this->instances[$key];
        }
        if (array_key_exists($key, $this->bindings)) {
            $resolver = $this->bindings[$key];
            $object = $resolver($this);
        } else {
            $object = $this->make($key);
        }


        // 3. Save to Cache for next time
        $this->instances[$key] = $object;

        return $object;
    }

    public function make(string $class)
    {
        if (!class_exists($class)) {
            throw new \Exception("Class {$class} does not exist and no binding was found.");
        }


        $ref = new ReflectionClass($class);


        if (!$ref->isInstantiable()) {
            throw new \Exception("Class {$class} is not instantiable.");
        }

        $ctor = $ref->getConstructor();
        if (!$ctor) {
            // no constructor → no dependencies
            return new $class;
        }

        $deps = [];

        foreach ($ctor->getParameters() as $param) {

            $type = $param->getType();

            if (!$type instanceof ReflectionNamedType || $type->isBuiltin()) {
                // Optional improvement: allow defaults
                if ($param->isDefaultValueAvailable()) {
                    $deps[] = $param->getDefaultValue();
                    continue;
                }
                throw new \Exception(
                    "Cannot resolve parameter \${$param->getName()} of {$class}"
                );
            }

            $deps[] = $this->resolve($type->getName());
        }

        return $ref->newInstanceArgs($deps);
    }
}
