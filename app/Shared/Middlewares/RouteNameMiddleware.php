<?php

namespace App\Shared\Middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Routing\RouteContext;

final class RouteNameMiddleware extends BaseMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler): ResponseInterface
    {
        $routeContext = RouteContext::fromRequest($request);
        $route = $routeContext->getRoute();

        if ($route === null) {
            return $handler->handle($request);
        }

        $this->twig->getEnvironment()->addGlobal('route_name', $route->getName());

        return $handler->handle($request);
    }
}
