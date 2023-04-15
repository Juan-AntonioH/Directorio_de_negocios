<?php

namespace App\Backend\Controllers\Auth;

use App\Backend\Services\AuthService;
use App\Shared\Controllers\FrontController;
use App\Shared\Helpers\RouteHelpers;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Flash\Messages as Flash;
use Slim\Views\Twig;

final class RegisterGetController extends FrontController
{
    private AuthService $authService;

    public function __construct(ContainerInterface $container, Twig $twig, Flash $flash, AuthService $authService)
    {
        parent::__construct($container, $twig, $flash);
        $this->authService = $authService;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        // Render index view
        if ($this->authService->check()) {
            return RouteHelpers::redirect($request, $response, 'dashboard');
        }

        return $this->twig->render($response, '@backend/auth/login-register.twig',['register' => true]);
    }
}