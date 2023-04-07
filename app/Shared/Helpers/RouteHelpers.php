<?php

namespace App\Shared\Helpers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Routing\RouteContext;

class RouteHelpers
{
    public static function redirect(RequestInterface $request, ResponseInterface $response, $url, $data = [], $queryParams = [])
    {
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor($url, $data, $queryParams);

        return $response
            ->withHeader('Location', $url)
            ->withStatus(302);
    }
}
