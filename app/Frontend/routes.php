<?php

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Backend\Controllers\DashboardController;

/*
 * FRONTEND APP ROUTES
 */

return function (App $app) {
    $app->group('/', function (RouteCollectorProxy $group) {
        // $group->get('', function (ServerRequestInterface $request, ResponseInterface $response) {
        //     $response->getBody()->write('Hello, World!');

        //     return $response;
        // });
        $group->get('', DashboardController::class)->setName('dashboard');  
    });
};
