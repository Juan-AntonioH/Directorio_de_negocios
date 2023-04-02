<?php

use Slim\App;

return function (App $app) {
    foreach (glob(dirname(__DIR__) . '/app/*/routes.php') as $route) {
        (require $route)($app);
    }
};
