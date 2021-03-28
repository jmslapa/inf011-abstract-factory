<?php

namespace Bootstrap;

use Mf\Bootstrap\Application as BootstrapApplication;

class Application extends BootstrapApplication
{
    protected function loadRoutes(): array
    {
        $routes  = require src('/routes/web.php');
        return $routes;
    }
}

