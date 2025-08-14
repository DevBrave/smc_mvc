<?php

namespace Core;

class Container
{


    protected $bindings = [];

    public function bind($key,$resolver)
    {
        $this->bindings[$key] = $resolver;
    }


    public function resolve($key)
    {
        if (!array_key_exists($key,$this->bindings)){
            throw new \Exception('There is no a valid key to get');
        }


        $resolver = $this->bindings[$key];


        return call_user_func($resolver); // the resolver will be a closure



    }

}