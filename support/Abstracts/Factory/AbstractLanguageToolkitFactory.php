<?php

namespace Support\Abstracts\Factory;

use Support\Contracts\Factories\LanguageToolkitFactoryContract;

abstract class AbstractLanguageToolkitFactory implements LanguageToolkitFactoryContract
{
    protected static ?array $instances = null;

    private function __construct()
    {
    }

    private function __clone()
    {
    }
    
    private function __sleep()
    {
    }

    private function __wakeup()
    {
    }

    final public static function getInstance(): LanguageToolkitFactoryContract
    {
        $class = get_called_class();
        if (!isset($instances[$class])) {
            $instances[$class] = new $class;
        }
        return $instances[$class];
    }
}
