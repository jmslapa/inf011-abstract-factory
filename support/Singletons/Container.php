<?php

namespace Support\Singletons;

use OutOfBoundsException;

final class Container
{

    private static ?Container $instance = null;

    private array $bindings;

    private function __construct()
    {
        $this->bindigs = [];
    }

    public static function getInstance(): Container
    {
        if (is_null(self::$instance)) {
            self::$instance = new Container;
        }
        return self::$instance;
    }

    public function resolve(string $bindingName)
    {
        if (!isset($this->bindings[$bindingName])) {
            throw new OutOfBoundsException('There are no results for the requested binding key.');
        }
        return is_callable($value = $this->bindings[$bindingName]) ? $value(): $value;
    }

    public function bind(string $bindingName, $value)
    {
        $this->bindings[$bindingName] = $value;
    }
}
