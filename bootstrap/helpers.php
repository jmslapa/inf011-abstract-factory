<?php

use Support\Singletons\Container;

if (!function_exists('container')) {
    function container(...$args)
    {
        $container = Container::getInstance();
        switch (count(func_get_args())) {
            case 1:
                return $container->resolve(...$args);
            case 2:
                return $container->bind(...$args);
            default:
                return $container;
        }
    }
}
