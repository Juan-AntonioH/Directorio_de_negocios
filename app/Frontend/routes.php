<?php

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

/*
 * FRONTEND APP ROUTES
 */

return function (App $app) {
    $app->group('/', function (RouteCollectorProxy $group) {
        $group->get('', function (ServerRequestInterface $request, ResponseInterface $response) {
            $response->getBody()->write('Hello, World!');

            return $response;
        });
    });
};
