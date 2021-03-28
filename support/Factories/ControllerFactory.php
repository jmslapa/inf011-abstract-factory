<?php

namespace Support\Factories;

use Mf\Contracts\Http\ControllerContract;

class ControllerFactory
{
    public static function make(string $controllerName) : ControllerContract
    {
        $class = "App\\Http\\Controllers\\{$controllerName}";
        return new $class;
    }
}