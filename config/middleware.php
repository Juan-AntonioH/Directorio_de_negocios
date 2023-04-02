<?php

use App\Shared\Middlewares\CsrfViewMiddleware;
use App\Shared\Middlewares\FlashMessageMiddleware;
use App\Shared\Middlewares\OldInputsMiddleware;
use App\Shared\Middlewares\RouteNameMiddleware;
use App\Shared\Middlewares\ValidationErrorsMiddleware;
use Slim\App;

return function (App $app) {
    // Add routename middleware
    $app->add(RouteNameMiddleware::class);

    // Parse json, form data and xml
    $app->addBodyParsingMiddleware();

    // Add the Slim built-in routing middleware
    $app->addRoutingMiddleware();

    // Add Flash Message Middleware
    $app->add(FlashMessageMiddleware::class);

    // Errors Middleware
    $app->add(ValidationErrorsMiddleware::class);

    // Old inputs middleware
    $app->add(OldInputsMiddleware::class);

    // CSRF Middlewares
    // $app->add(CsrfViewMiddleware::class);
    // $app->add('csrf');

    // Handle exceptions
    $app->addErrorMiddleware(true, true, true);
};
