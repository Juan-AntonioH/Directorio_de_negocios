<?php

namespace App\Backend\Middlewares;

use App\Backend\Services\AuthService;
use App\Shared\Helpers\RouteHelpers;
use App\Shared\Middlewares\BaseMiddleware;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Routing\RouteContext;
use Slim\Views\Twig;

final class AuthMiddleware extends BaseMiddleware
{
    /**
     * @var AuthService
     */
    private $authService;

    public function __construct(ContainerInterface $container, Twig $twig, AuthService $authService)
    {
        parent::__construct($container, $twig);
        $this->authService = $authService;
    }

    public function __invoke(Request $request, RequestHandler $handler): ResponseInterface
    {
        $response = $handler->handle($request);

        if (!$this->authService->check()) {
            return RouteHelpers::redirect($request, $response, 'auth.get.login');
        }

        $rolesToCheck = RouteContext::fromRequest($request)->getRoute()->getArgument('roles');

        if (!is_null($rolesToCheck) && !$this->authService->hasRole(explode(',', $rolesToCheck))) {
            return RouteHelpers::redirect($request, $response, 'dashboard');
        }

        return $response;
    }
}
