<?php

namespace App\Backend\Controllers\Auth;

use App\Backend\Services\AuthService;
use App\Shared\Controllers\PostController;
use App\Shared\Helpers\RouteHelpers;
use App\Shared\Validation\Validator;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Validator as v;
use Slim\Flash\Messages as Flash;

final class LoginPostController extends PostController
{
    private AuthService $authService;

    public function __construct(ContainerInterface $container, Validator $validator, Flash $flash, AuthService $authService)
    {
        parent::__construct($container, $validator, $flash);
        $this->authService = $authService;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $validation = $this->validator->validate($request, [
            'email' => v::email()->noWhitespace()->notEmpty(),
            'password' => v::noWhitespace()->notEmpty(),
        ]);

        if ($validation->failed()) {
            return RouteHelpers::redirect($request, $response, 'auth.get.login');
        }

        $signIn = $this->authService->signIn(
            $request->getParsedBody()['email'],
            $request->getParsedBody()['password']
        );

        if (!$signIn) {
            return RouteHelpers::redirect($request, $response, 'auth.get.login');
        }

        return RouteHelpers::redirect($request, $response, 'dashboard');
    }
}
