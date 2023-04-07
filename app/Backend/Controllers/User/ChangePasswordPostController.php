<?php

namespace App\Backend\Controllers\User;

use App\Backend\Services\AuthService;
use App\Backend\Services\UserService;
use App\Shared\Controllers\PostController;
use App\Shared\Helpers\RouteHelpers;
use App\Shared\Validation\Validator;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Validator as v;
use Slim\Flash\Messages as Flash;

final class ChangePasswordPostController extends PostController
{
    private UserService $userService;
    private AuthService $authService;

    public function __construct(ContainerInterface $container, Validator $validator, Flash $flash, UserService $userService, AuthService $authService)
    {
        parent::__construct($container, $validator, $flash);
        $this->userService = $userService;
        $this->authService = $authService;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $validation = $this->validator->validate($request, [
            'oldPassword' => v::noWhitespace()->notEmpty()->verifyOldPassword($this->authService->getUser()->password),
            'password' => v::noWhitespace()->notEmpty(),
            'confirmPassword' => v::noWhitespace()->notEmpty()->equalsPasswords($request->getParsedBody()['password']),
        ]);

        if ($validation->failed()) {
            return RouteHelpers::redirect($request, $response, 'user.edit.account');
        }

        $this->userService->changePassword($this->authService->getUser(), $request->getParsedBody()['password']);

        return RouteHelpers::redirect($request, $response, 'user.edit.account');
    }
}
