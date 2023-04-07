<?php

namespace App\Backend\Controllers\Auth;

use App\Backend\Services\AuthService;
use App\Shared\Helpers\RouteHelpers;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class LogoutPostController
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $this->authService->logout();

        return RouteHelpers::redirect($request, $response, 'auth.get.login');
    }
}
