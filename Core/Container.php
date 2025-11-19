<?php

namespace Core;

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

        if (!array_key_exists($key, $this->bindings)) {
            throw new \Exception("No binding found for {$key}");
        }

        // 2. Create it
        $resolver = $this->bindings[$key];
        $object = call_user_func($resolver);

        // 3. Save to Cache for next time
        $this->instances[$key] = $object;

        return $object;
    }
}