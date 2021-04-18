<?php

namespace Bootstrap;

use ReflectionClass;
use App\Services\LanguageService;
use Support\Singletons\Container;
use Mf\Bootstrap\Application as BootstrapApplication;
use Support\Abstracts\Factory\AbstractLanguageToolkitFactory;

class Application extends BootstrapApplication
{
    private Container $container;

    protected function loadRoutes(): array
    {
        $routes  = require src('/routes/web.php');
        return $routes;
    }

    protected function boot()
    {
        $this->container = Container::getInstance();
        $this->registerHelpers();
        $this->registerBindings();
        $this->registerLanguageToolkits();
        parent::boot();
    }

    private function registerBindings()
    {
        $this->container->bind('languageService', new LanguageService);
    }

    private function registerLanguageToolkits()
    {
        $dirs = preg_grep('/^([^.])/', scandir(src('plugins/Lang/Toolkits')));
        $suffix = 'ToolkitFactory';
        $supportedLangsKeyName = 'supportedLangs';

        $this->container->bind($supportedLangsKeyName, []);
        foreach ($dirs as $lang) {
            $parentClass = AbstractLanguageToolkitFactory::class;
            $class = "\\Plugins\\Lang\\Toolkits\\$lang\\Factory\\LanguageToolkitFactory";
            if (class_exists($class) && (new ReflectionClass($class))->isSubclassOf($parentClass)) {
                $supportedLangs = $this->container->resolve($supportedLangsKeyName);
                $this->container->bind(lcfirst($lang.$suffix), $class::getInstance());
                $this->container->bind($supportedLangsKeyName, [...$supportedLangs, strtolower($lang)]);
            }
        }
    }

    private function registerHelpers()
    {
        require_once 'helpers.php';
    }
}
