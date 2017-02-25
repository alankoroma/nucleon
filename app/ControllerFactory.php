<?php

namespace App;

class ControllerFactory
{
    /**
     * @var callable
     */
    private $callback;
    /**
     * Creates a new controller factory.
     *
     * @param callable $callback
     */
    function __construct($callback)
    {
        $this->callback = $callback;
    }
    /**
     * Creates a new controller by instantiating the controller class
     * with the provided arguments. The factory callback is applied
     * to the newly created instance.
     *
     * @param  string $class
     * @param  mixed  ...
     */
    public function create($class)
    {
        $reflection = new \ReflectionClass($class);
        $args = func_get_args();
        /* Remove the class name from args */
        array_shift($args);
        /* Instantiate the controller with the provided arguments */
        $controller = $reflection->newInstanceArgs($args);
        /* Apply the factory callback */
        call_user_func($this->callback, $controller);
        return $controller;
    }
}
